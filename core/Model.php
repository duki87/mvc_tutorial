<?php

  namespace Core;
  use Core\H;
  // use Core\Router;

  class Model
  {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [], $_validates = true, $_validationErrors = [];
    public $id;

    public function __construct($table)
    {
      $this->_db = DB::getInstance();
      $this->_table = $table;
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_',' ', $this->_table)));
    }

    public function getColumns()
    {
      return $this->_db->getColumns($this->_table);
    }

    public function find($params = [])
    {
      $params = $this->_softDeleteParams($params);
      $results = [];
      $resultsQuery = $this->_db->find($this->_table, $params, get_class($this));
      return $resultsQuery;
    }

    public function findFirst($params = [])
    {
      $params = $this->_softDeleteParams($params); //delete if there is a problem!
      $resultsQuery = $this->_db->findFirst($this->_table, $params, get_class($this));
      return $resultsQuery;
    }

    public function findById($id)
    {
      return $this->first([
        'conditions' => ['id'],
        'bind' => [$id],
        //'order' => ['id'],
        //'limit' => 1
      ]);
    }

    public function save()
    {
      $fields = H::getObjectProperties($this);
      //Determine whether to update or insert new record
      if(property_exists($this, 'id') && $this->id != '') {
        $save = $this->update([$this->id], $fields);
        $this->afterSave();
        return $save;
      }
      $save = $this->insert($fields);
      $this->afterSave();
      return $save;
    }

    public function insert($fields)
    {
      if(empty($fields)) return false;
      return $this->_db->insert($this->_table, $fields);
    }

    //New update function without $where
    public function update($fields = [])
    {
      if(empty($fields)) {
        //H::dnd($this);
        return $this->_db->update($this->_table, ['id' => $this->id], $this);
      } else {
        return $this->_db->update($this->_table, ['id' => $this->id], $fields);
      }
    }

    public function delete($where = [])
    {
      if(empty($where)) {
        if($this->_softDelete) {
          return $this->update(['deleted' => 1]);
        }
        return $this->_db->delete($this->_table, ['id' => $this->id]);
      } else {
        if($this->_softDelete) {
          return $this->update($where, ['deleted' => 1]);
        }
        return $this->_db->delete($this->_table, $where);
      }
    }

    public function query($sql, $bind)
    {
      return $this->_db->query($sql, $bind);
    }

    public function data()
    {
      $data = new stdClass();
      foreach(H::getObjectProperties($this) as $key => $value) {
        $data->key = $value;
      }
      return $data;
    }

    public function assign($params)
    {
      if(!empty($params)) {
        foreach($params as $key => $value) {
          if(property_exists($this, $key)) {
            $this->{$key} = $value;
          }
        }
        return true;
      }
      return false;
    }

    protected function populateObj($result)
    {
      foreach($result as $key => $value) {
        $this->{$key} = $value;
      }
    }

    protected function getLastInsertId()
    {
      return $this->_db->lastInsertId();
    }

    protected function _softDeleteParams($params)
    {
      if($this->_softDelete) {
        if(array_key_exists('conditions', $params)) {
          if(is_array($params['conditions'])) {
            $params['conditions'][] = 'deleted';
          }
          if(array_key_exists('bind', $params)) {
            if(is_array($params['bind'])) {
              $params['bind'][] = 0;
            }
          }
        }
      }
      return $params;
    }

    public function validator()
    {

    }

    public function runValidation($validator)
    {
      //H::dnd($validator->success);
      $key = $validator->field;
      if(!$validator->success) {
        $this->_validates = false;
        $this->_validationErrors[$key] = $validator->message;
      }
    }

    public function getErrorMessages()
    {
      return $this->_validationErrors;
    }

    public function validationPassed()
    {
      return $this->_validates;
    }

    public function addErrorMessage($field, $message)
    {
      $this->_validates = false;
      $this->_validationErrors[$field] = $message;
    }

    public function beforeSave()
    {

    }

    public function afterSave()
    {

    }
  }
