<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;

  class MaxValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = (strlen($value)) <= $this->_rule;
      return $pass;
    }
  }
