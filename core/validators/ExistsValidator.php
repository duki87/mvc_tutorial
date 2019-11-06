<?php

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
