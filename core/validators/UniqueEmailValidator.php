<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;
  use App\Models\Users;

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
