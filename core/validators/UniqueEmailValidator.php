<?php

  class UniqueEmailValidator extends MainValidator
  {

    public function runValidation()
    {
      // $queryParams = [];
      // $field = (is_array($this->_field)) ? $this->_field[0] : $this->_field;
      // $value = $this->_value;
      // $conditions = [$field];
      // $bind = [$value];
      //
      // if(!empty($this->_model->id)) {
      //   $conditions[] = 'id';
      //   $bind[] = $this->_model->id;
      // }
      //
      // //check multiple fields for unique
      // if(is_array($this->field)) {
      //   array_unshift($this->field);
      //   foreach($this->field as $add) {
      //     $conditions[] = $add;
      //     $bind[] = $this->_model->{$add};
      //   }
      // }
      // $queryParams['conditions'] = $conditions;
      // $queryParams['bind'] = $bind;
      // $unique = $this->_model->findFirst($queryParams);
      // return (!$unique);
      $email = $this->_value;
      $user = new Users($email);
      $unique = $user->id;
      return !isset($unique) ? true : false;
    }
  }
