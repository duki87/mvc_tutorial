<?php

  namespace Core\Validators;
  use Core\Validators\MainValidator;
  use App\Models\Users;

  class ExistsValidator extends MainValidator
  {
    public function runValidation()
    {
      $field = $this->_value;
      $user = new Users($field);
      $unique = $user->id;
      return !isset($unique) ? true : false;
    }
  }
