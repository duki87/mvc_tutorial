<?php

  class Input
  {

    public $inputs = [];

    public function get($input = false)
    {
      if(!$input) {
        //return entire request array and sanitize it
        $data = [];
        foreach($_REQUEST as $field => $value) {
          $data[$field] = FH::sanitize($value);
        }
        return $data;
      }
      return FH::sanitize($_REQUEST[$input]);
    }

    public function formInputs($inputs = [])
    {
      foreach($inputs as $key => $value) {
        $this->inputs[$key] = $value;
      }
    }

    public function getInputValues($field)
    {
      //return $field;
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
