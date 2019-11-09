<?php
  class DB
  {
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_results, $_count = 0, $_lastInsertId = null;

    private function __construct()
    {
      try {
        $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    }

    public static function getInstance()
    {
      if(!isset(self::$_instance))
      {
        self::$_instance = new DB();
      }
      return self::$_instance;
    }

    public function query($sql, $params = [], $class = false)
    {
      $this->_error = false;
      if($this->_query = $this->_pdo->prepare($sql))
      {
        $x = 1;
        if(count($params))
        {
          foreach($params as $param) {
            $this->_query->bindValue($x, $param);
            $x++;
          }
        }

        if($this->_query->execute()) {
          if($class) {
            $this->_results = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
          } else {
            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
          }
          $this->_count = $this->_query->rowCount();
          $this->_lastInsertId = $this->_pdo->lastInsertId();
        }
        else
        {
          $this->_error = true;
        }
      }
      return $this;
    }

    public function insert($table, $fields = [])
    {
      $fieldString = '';
      $valueString = '';
      $values = [];

      foreach($fields as $field => $value) {
        //MySQL won't insert if id == null, so we need to delete this field
        if($field === 'id') {
          continue;
        }
        $fieldString .= '`' . $field . '`,';
        $valueString .= '?,';
        $values[] = $value;
      }

      $fieldString = rtrim($fieldString, ',');
      $valueString = rtrim($valueString, ',');
      $sql = "INSERT INTO $table ({$fieldString}) VALUES ({$valueString})";
      if(!$this->query($sql, $values)->error()) {
        return true;
      }
      return false;
    }

    public function update($table, $where = [], $fields = [])
    {
      $whereString = '';
      $whereValues = [];
      $fieldString = '';
      $values = [];
      foreach ($fields as $field => $value) {
        $fieldString .= ' `' . $field . '` = ?,';
        $values[] = $value;
        echo $value . '<br>';
      }

      foreach($where as $column => $colValue) {
        $whereString .= '`' . $column . '` = ? AND ';
        $values[] = $colValue;
        echo $colValue . '<br>';
      }
      $whereString = rtrim($whereString, 'AND ');

      $fieldString = rtrim($fieldString, ',');
      $fieldString = trim($fieldString, ' ');
      $sql = "UPDATE $table SET {$fieldString} WHERE {$whereString}";
      if(!$this->query($sql, $values)->error()) {
        return true;
      }
      return false;
    }

    public function delete($table, $where = [])
    {
      $fieldString = '';
      $values = [];
      foreach ($where as $field => $value) {
        $fieldString .= ' `' . $field . '` = ? AND';
        $values[] = $value;
        //echo $value . '<br>';
      }
      $fieldString = rtrim($fieldString, 'AND ');
      $fieldString = trim($fieldString, ' ');
      $sql = "DELETE FROM $table WHERE {$fieldString}";
      if(!$this->query($sql, $values)->error()) {
        return true;
      }
      return false;
    }

    public function results()
    {
      return $this->_results;
    }

    public function first()
    {
      return (!empty($this->_results)) ? $this->_results[0] : [];
    }

    public function count()
    {
      return $this->_count;
    }

    public function lastId()
    {
      return $this->_lastInsertId;
    }

    public function getColumns($table)
    {
      return $this->query("SHOW COLUMNS from {$table}")->results();
    }

    public function find($table, $params = [], $class = false)
    {
      if($this->_read($table, $params, $class)) {
        return $this->results();
      }
      return false;
    }

    public function findFirst($table, $params = [], $class = false)
    {
      if($this->_read($table, $params, $class)) {
        return $this->first();
      }
      return false;
    }

    protected function _read($table, $params = [], $class)
    {
      $conditionString = '';
      $bind = [];
      $order = '';
      $limit = '';

      //conditions
      if(isset($params['conditions'])) {

        if(is_array($params['conditions'])) {
          foreach($params['conditions'] as $condition) {
            $conditionString .= ' `' . $condition . '` = ? AND';
          }

          $conditionString = trim($conditionString);
          $conditionString = rtrim($conditionString, ' AND');
        } else {
          $conditionString = '`' . $params['conditions'] . '` = ?';
        }
        if($conditionString != '') {
          $conditionString = 'WHERE ' . $conditionString;
        }
      }
      //bind
      if(array_key_exists('bind', $params)) {
        $bind = $params['bind'];
      }
      //order
      if(array_key_exists('order', $params)) {
        $order .= ' ORDER BY ';
        foreach($params['order'] as $value) {
          $order .= $value . ', ';
        }
        $order = rtrim($order, ', ');
      }
      //limit
      if(array_key_exists('limit', $params)) {
        $limit = 'LIMIT ' . $params['limit'];
      }
      $sql = "SELECT * FROM {$table} {$conditionString} {$order} {$limit}";
      $sql = rtrim($sql, ' '); //delete if makes a problem
      if($this->query($sql, $bind, $class)) {
        if(!count($this->_results)) return false;
        return true;
      }
      return false;
    }

    public function error()
    {
      return $this->_error;
    }

    public function lastInsertId()
    {
      return $this->_lastInsertId;
    }
  }
