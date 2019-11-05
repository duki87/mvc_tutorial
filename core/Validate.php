<?php

  class Validate
  {
    private $_passed = false, $_errors = [], $_db = null;
    protected $_errorFields = [], $_validates = true;

    public function __construct()
    {
      $this->_db = DB::getInstance();
    }

    // public function check($source, $items = [], $csrfCheck = false)
    // {
    //   $this->_errors = [];
    //   if($csrfCheck) {
    //     $csrfCheck = FH::checkToken($source['csrf_token']);
    //     if(!$csrfCheck) {
    //       $this->addError(["Something has gone wrong!", 'csrf_token']);
    //     }
    //   }
    //   foreach($items as $item => $rules) {
    //     $item = FH::sanitize($item);
    //     $display = $rules['display'];
    //     foreach($rules as $rule => $ruleValue) {
    //       $value = FH::sanitize(trim($source[$item]));
    //       if($rule === 'required' && empty($value)) {
    //         $this->addError(["{$display} is required!", $item]);
    //       } else if(!empty($value)) {
    //         switch ($rule) {
    //           case 'min':
    //             if(strlen($value) < $ruleValue) {
    //               $this->addError(["{$display} must have at least {$ruleValue} characters!", $item]);
    //             }
    //             break;
    //           case 'max':
    //             if(strlen($value) > $ruleValue) {
    //               $this->addError(["{$display} must have less then {$ruleValue} characters!", $item]);
    //             }
    //             break;
    //           case 'matches':
    //             if($value != $source[$ruleValue]) {
    //               $matchDisplay = $items[$ruleValue]['display'];
    //               $this->addError(["{$matchDisplay} and {$display} must match!", $item]);
    //             }
    //             break;
    //           case 'unique':
    //             $check = $this->_db->query("SELECT {$item} FROM {$ruleValue} WHERE {$item} = ?", [$value]);
    //             if($check->count()) {
    //               $this->addError(["{$display} already exists! Please choose another {$display}", $item]);
    //             }
    //             break;
    //           case 'uniqueUpdate':
    //             $t = explode(',', $ruleValue);
    //             $table = $t[0];
    //             $id = $t[1];
    //             $check = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
    //             if($check->count()) {
    //               $this->addError(["{$display} already exists! Please choose another {$display}", $item]);
    //             }
    //             break;
    //           case 'isNumeric':
    //             if(!is_numeric($value)) {
    //               $this->addError(["{$display} must be a numeric value!", $item]);
    //             }
    //             break;
    //           case 'validEmail':
    //             if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    //               $this->addError(["{$display} must be a valid email address!", $item]);
    //             }
    //             break;
    //           default:
    //
    //             break;
    //         }
    //       }
    //     }
    //   }
    //   if(empty($this->_errors)) {
    //     $this->_passed = true;
    //   }
    //   return $this;
    // }

    public function addError($error)
    {
      $this->_errors[] = $error;
      if(empty($this->_errors)) {
        $this->_passed = true;
      } else {
        $this->_passed = false;
      }
    }

    public function errors()
    {
      return $this->_errors;
    }

    public function displayErrors()
    {
      if(empty($this->_errors)) {
        return '';
      }
      $html = '<div class="alert alert-danger" role="alert"><ul class="">';
      foreach ($this->_errors as $error) {
        if(is_array($error)) {
          $html .= '<li class="">'.$error[0].'</li>';
          $html .= '<script>$(document).ready(function(){ $("#'.$error[1].'").addClass("is-invalid"); });</script>';
        } else {
          $html .= '<li class="">'.$error.'</li>';
        }
      }
      $html .= '</div></ul>';
      return $html;
    }

    //New validation

    public static function check($params = [])
    {
      $errorMessages = H::readFile('errorMessages.json');
      $validateClass = new self;
      $input = new Input();

      $inputValues = $input->get();
      $validateOptions = [];
      foreach($params as $field => $rules) {
        foreach($rules as $key => $value) {
          $message = '';
          if(filter_var($value, FILTER_VALIDATE_INT) === false) {
            $message = $errorMessages[$key];
          } else {
            $message = $errorMessages[$key] . ($value == 1 ? '!' : ' ' . $value . '!');
          }
          $validatorClassName = ucwords($key).'Validator';
          //$validateOptions[] = ['field' => $field, 'value' => $inputValues[$field], 'rule' => $value, 'validatorClass' => $validatorClassName, 'msg' => $message];
          $validateClass->runValidation(new $validatorClassName(['value' => $inputValues[$field], 'rule' => $value, 'field' => $field, 'msg' => $message]));
        }
      }
      //H::dnd($validateClass->_errorFields);
    }

    public function runValidation($validator)
    {
      //H::dnd($validator->success);
      $key = $validator->_field;
      if(!$validator->success) {
        $this->_validates = false;
        if(!isset($this->_errorFields[$key])) {
          $this->_errorFields[$key] = $validator->message;
        }
      }
      Session::set('formErrors', $this->_errorFields);
    }

    public function fails()
    {
      return $this->_validates;
    }

    public function passed()
    {
      return $this->_validates;
    }
  }
