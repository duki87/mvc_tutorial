<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;
  use App\Models\Users;

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
