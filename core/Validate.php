<?php

  class Validate
  {
    private $_passed = false, $_db = null;
    protected $_errorFields = [], $_validates = false;
    public static $errors = [];

    public function __construct()
    {
      $this->_db = DB::getInstance();
    }

    public static function displayErrors()
    {
      $html = '';
      if(!empty(self::$errors)) {
        $html .= '<div class="alert alert-danger" role="alert"><ul class="">';
        $errors = self::$errors;
        foreach ($errors as $field => $error) {
          $html .= '<li class="">'.$error.'</li>';
          $html .= '<script>$(document).ready(function(){ $("#'.$field.'").addClass("is-invalid"); });</script>';
        }
        $html .= '</div></ul>';
      }
      return $html;
    }

    //New validation

    public static function check($params = [])
    {
      $input = new Input();
      if($input->csrfCheck()) {
        $errorMessages = H::readFile('errorMessages.json');
        $validateClass = new self;
        $inputValues = $input->get();
        $validateOptions = [];
        foreach($params as $field => $rules) {
          foreach($rules as $key => $value) {
            $message = $errorMessages[$key];
            //Replace FIELD and VALUE words in message with corresponding values
            $messageArray = explode(" ", $message);
            if(in_array("FIELD", $messageArray)) {
              $label = Session::getFormFieldNames($field);
              $message = str_replace("FIELD", $label, $message);
            }
            if(in_array("VALUE", $messageArray)) {
              $message = str_replace("VALUE", $value, $message);
            }
            $message .= '!';
            $validatorClassName = ucwords($key).'Validator';
            $validateClass->runValidation(new $validatorClassName([
              'value' => $inputValues[$field],
              'rule' => (is_int($value) || is_bool($value)) ? $value : $inputValues[$value],
              'field' => $field,
              'msg' => $message
            ]));
          }
        }
      }
    }

    public function runValidation($validator)
    {
      $key = $validator->_field;
      if(!$validator->success) {
        $this->_validates = false;
        if(!isset($this->_errorFields[$key])) {
          self::$errors[$key] = $validator->message;
        }
      } else {
      Session::set('formErrors', self::$errors);
    }

    public function fails()
    {
      return !empty(self::$errors) ? true : false;
    }

    public function passed()
    {
      return empty(self::$errors) ? true : false;
    }
  }
