<?php

  class ValidEmailValidator extends MainValidator
  {

    public function runValidation()
    {
      $email = $this->_value;
      $pass = true;
      if(!empty($email)) {
        $pass = filter_var($email, FILTER_VALIDATE_EMAIL);
      }
      return $pass;
    }
  }
