<?php

  class RequiredValidator extends CustomValidator
  {

    public function runValidation()
    {
      $value = $this->_model->{$this->field};
      $pass = (empty($value)) ? false : true;
      return $pass;
    }

  }
