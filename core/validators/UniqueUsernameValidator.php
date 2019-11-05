<?php

  class UniqueUsernameValidator extends MainValidator
  {

    public function runValidation()
    {
      $username = $this->_value;
      $user = new Users($username);
      $unique = $user->id;
      return !isset($unique) ? true : false;
    }
  }
