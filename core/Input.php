<?php

  namespace Core;
  use Core\FH;
  use Core\Router;

  class Input
  {
    public $inputs = [];
    public static $previousValues = [];

    public function get($input = false)
    {
      if(!$input) {
        //return entire request array and sanitize it
        $data = [];
        foreach($_REQUEST as $field => $value) {
          $data[$field] = FH::sanitize($value);
        }
        self::$previousValues = $data;
        return $data;
      }
      return FH::sanitize($_REQUEST[$input]);
    }

    public static function getPreviousValues($field)
    {
      if(isset(self::$previousValues[$field])) {
        return self::$previousValues[$field];
      }
    }

    public static function setPreviousValues($values)
    {
      self::$previousValues = (array) $values;
    }

    public function getInputValues($field)
    {
      return (array_key_exists($field, $this->inputs)) ? $this->inputs[$field] : '';
    }

    public function isPost()
    {
      return $this->getRequestMethod() === 'POST';
    }

    public function isPut()
    {
      return $this->getRequestMethod() === 'PUT';
    }

    public function isGet()
    {
      return $this->getRequestMethod() === 'GET';
    }

    public function getRequestMethod()
    {
      return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function csrfCheck()
    {
      if(!FH::checkToken($this->get('csrf_token'))) {
        Router::redirect('restricted/bad_token');
      }
      return true;
    }
  }
