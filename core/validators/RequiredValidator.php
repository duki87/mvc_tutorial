<?php

  class RequiredValidator extends MainValidator
  {

    public function runValidation()
    {
      $value = $this->_value;
      $pass = (empty($value)) ? false : true;
      return $pass;
    }
  }
