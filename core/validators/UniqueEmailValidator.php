<?php

  class UniqueEmailValidator extends MainValidator
  {

    public function runValidation()
    {
      $email = $this->_value;
      $user = new Users($email);
      $unique = $user->id;
      return !isset($unique) ? true : false;
    }
  }
