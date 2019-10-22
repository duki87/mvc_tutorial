<?php
  class Model
  {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
    public $id;

    public function __construct($table)
    {
      $this->_db = DB::getInstance();
      $this->_table = $table;
      //$this->_setTableColumns();
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_',' ', $this->_table)));
    }

    //for delete
    // protected function _setTableColumns()
    // {
    //   $columns = $this->getColumns();
    //   foreach ($columns as $column) {
    //     $columnName = $column->Field;
    //     $this->_columnNames[] = $column->Field;
    //     $this->{$columnName} = null;
    //   }
    // }

    public function getColumns()
    {
      return $this->_db->getColumns($this->_table);
    }

    public function find($params = [])
    {
      $params = $this->_softDeleteParams($params); //delete if there is a problem!
      $results = [];
      $resultsQuery = $this->_db->find($this->_table, $params, get_class($this));
      // foreach($resultsQuery as $result) {
      //   $obj = new $this->_modelName($this->_table);
      //   $obj->populateObj($result);
      //   $results[] = $obj;
      // }
      //return $results;
      return $resultsQuery;
    }

    public function findFirst($params = [])
    {
      $params = $this->_softDeleteParams($params); //delete if there is a problem!
      $resultsQuery = $this->_db->findFirst($this->_table, $params, get_class($this));
      // $result = new $this->_modelName($this->_table);
      // if($resultsQuery) {
      //   $result->populateObj($resultsQuery);
      // }
      // return $result;
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
      //$fields = [];
      $fields = getObjectProperties($this);

      // foreach($this->_columnNames as $column) {
      //   $fields[$column] = $this->{$column};
      // }

      //Determine whether to update or insert new record
      if(property_exists($this, 'id') && $this->id != '') {
        return $this->update([$this->id], $fields);
      }
      return $this->insert($fields);
    }

    public function insert($fields)
    {
      if(empty($fields)) return false;
      return $this->_db->insert($this->_table, $fields);
    }

    //New update function without $where
    public function update($fields)
    {
      if(empty($fields)) {
        return false;
      }
      return $this->_db->update($this->_table, ['id' => $this->id], $fields);
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
      // foreach ($this->_columnNames as $column) {
      //   $data->column = $this->column;
      // }
      foreach(getObjectProperties($this) as $key => $value) {
        $data->key = $value;
      }
      return $data;
    }

    public function assign($params)
    {
      if(!empty($params)) {
        foreach($params as $key => $value) {
          // if(in_array($key, $this->_columnNames)) {
          //   $this->{$key} = sanitize($value);
          // }
          if(property_exists($this, $key)) {
            $this->{$key} = sanitize($value);
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
      // if($this->_softDelete) {
      //   if(array_key_exists('conditions', $params)) {
      //     if(is_array($params['conditions'])) {
      //       $params['conditions'][] = "deleted != 1";
      //     } else {
      //       $params['conditions'] .= " AND deleted != 1";
      //     }
      //   } else {
      //     $params['conditions'] = "deleted != 1";
      //   }
      // }
      // return $params;
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
  }
