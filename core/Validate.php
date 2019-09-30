<?php

  class Validate
  {
    private $_passed = false, $_errors = [], $_db = null, $_errorFields = [];

    public function __construct()
    {
      $this->_db = DB::getInstance();
    }

    public function check($source, $items = [])
    {
      $this->_errors = [];
      foreach($items as $item => $rules) {
        $item = Input::sanitize($item);
        $display = $rules['display'];
        foreach($rules as $rule => $ruleValue) {
          $value = Input::sanitize(trim($source[$item]));
          if($rule === 'required' && empty($value)) {
            $this->addError(["{$display} is required!", $item]);
          } else if(!empty($value)) {
            switch ($rule) {
              case 'min':
                if(strlen($value) < $ruleValue) {
                  $this->addError(["{$display} must have at least {$ruleValue} characters!", $item]);
                }
                break;
              case 'max':
                if(strlen($value) > $ruleValue) {
                  $this->addError(["{$display} must have less then {$ruleValue} characters!", $item]);
                }
                break;
              case 'matches':
                if($value != $source[$ruleValue]) {
                  $matchDisplay = $items([$ruleValue]['display']);
                  $this->addError(["{$matchDisplay} and {$display} must match!", $item]);
                }
                break;
              case 'unique':
                $check = $this->_db->query("SELECT {$item} FROM {$ruleValue} WHERE {$item} = ?", [$value]);
                if($check->count()) {
                  $this->addError(["{$display} already exists! Please choose another {$display}", $item]);
                }
                break;
              case 'uniqueUpdate':
                $t = explode(',', $ruleValue);
                $table = $t[0];
                $id = $t[1];
                $check = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
                if($check->count()) {
                  $this->addError(["{$display} already exists! Please choose another {$display}", $item]);
                }
                break;
              case 'isNumeric':
                if(!is_numeric($value)) {
                  $this->addError(["{$display} must be a numeric value!", $item]);
                }
                break;
              case 'validEmail':
                if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                  $this->addError(["{$display} must be a valid email address!", $item]);
                }
                break;
              default:

                break;
            }
          }
        }
      }
      if(empty($this->_errors)) {
        $this->_passed = true;
      }
      return $this;
    }

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

    public function passed()
    {
      return $this->_passed;
    }

    public function displayErrors()
    {
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
  }
