<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;

  class PasswordMatchesValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = $value == $this->_rule;
      return $pass;
    }
  }
