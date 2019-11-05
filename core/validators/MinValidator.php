<?php

  class MinValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = (strlen($value)) >= $this->_rule;
      return $pass;
    }
  }
