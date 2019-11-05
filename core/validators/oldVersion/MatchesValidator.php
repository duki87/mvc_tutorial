<?php

  class MatchesValidator extends CustomValidator
  {

    public function runValidation()
    {
      $value = $this->_model->{$this->field};
      $pass = $value == $this->rule;
      return $pass;
    }
  }
