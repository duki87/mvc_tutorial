<?php

  class PasswordMatchesValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = $value == $this->_rule;
      return $pass;
    }
  }
