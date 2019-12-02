<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;

  class NumericValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = true;
      if(!empty($value)) {
        $pass = is_numeric($value);
      }
      return $pass;
    }
  }
