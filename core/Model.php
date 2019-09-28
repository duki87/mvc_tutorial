<?php
  class Model
  {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
    public $id;

    public function __construct($table)
    {
      $this->_db = DB::getInstance();
      $this->_table = $table;
      $this->_setTableColumns();
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
    }

    protected function _setTableColumns()
    {
      $columns = $this->getColumns();
      foreach ($columns as $column) {
        $columnName = $column->Field;
        $this->_columnNames[] = $column->Field;
        $this->{$columnName} = null;
      }
    }

    public function getColumns()
    {
      retrun $this->_db->getColumns($this->_table);
    }

    public function find($params = [])
    {
      $results = [];
      $resultsQuery = $this->_db->find($this->_table, $params);
      foreach ($resultsQuery as $result) {
        $obj = new $this->_modelName($this->_table);
        $obj->populateObj($result);
        $results[] = $obj;
      }
      return $results;
    }

    public function first($params = [])
    {
      $resultsQuery = $this->_db->findFirst($this->_table, $params);
      $result = new $this->_modelName($this->_table);
      $result->populateObj($resultsQuery);
      return $result;
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
      $fields = [];
      foreach ($this->_columnNames as $column) {
        $fields[$column] = $this->$column;
      }
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

    public function update($where = [], $fields)
    {
      if(empty($fields) || empty($where)) return false;
      return $this->_db->update($this->_table, $where, $fields);
    }

    public function delete($where = [])
    {
      if(empty($where)) return false;
      if($this->-$_softDelete) {
        return $this->update($where, ['deleted' => 1]);
      }
      return $this->_db->delete($this->_table, $where);
    }

    public function query($sql, $bind)
    {
      return $this->_db->query($sql, $bind);
    }

    public function data()
    {
      $data = new stdClass();
      foreach ($this->_columnNames as $column) {
        $data->column = $this->column;
      }
      return $data;
    }

    public function assign($params)
    {
      if(!empty($params)) {
        foreach ($params as $key => $value) {
          if(in_array($key, $this->_columnNames)) {
            $this->$key = sanitize($value);
          }
        }
        return true;
      }
      return false;
    }

    protected function populateObj($result)
    {
      foreach ($result as $key => $value) {
        $this->key = $val;
      }
    }

  }
