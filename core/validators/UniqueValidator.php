<?php

  class UniqueValidator extends CustomValidator
  {

    public function runValidation()
    {
      $queryParams = [];
      $field = (is_array($this->field)) ? $this->field[0] : $this->field;
      $value = $this->_model->{$field};
      $conditions = [$field];
      $bind = [$value];

      if(!empty($this->_model->id)) {
        $conditions[] = 'id';
        $bind[] = $this->_model->id;
      }

      //check multiple fields for unique
      if(is_array($this->field)) {
        array_unshift($this->field);
        foreach($this->field as $add) {
          $conditions[] = $add;
          $bind[] = $this->_model->{$add};
        }
      }
      $queryParams['conditions'] = $conditions;
      $queryParams['bind'] = $bind;
      $unique = $this->_model->findFirst($queryParams);
      return (!$unique);
    }
  }
