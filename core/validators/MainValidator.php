<?php

  abstract class MainValidator
  {
    public $success = true, $message = '', $_value, $_field, $_rule;

    public function __construct($params)
    {
      //H::dnd($params);
      $this->_value = $params['value'];
      if(!array_key_exists('field', $params)) {
        throw new Exception("You must add field to the params array!");
      } else {
        $this->_field = (is_array($params['field'])) ? $params['field'][0] : $params['field'];
      }

      // if(!property_exists($value, $this->_field)) {
      //   throw new Exception("Field must exists in the model class!");
      // }

      if(!array_key_exists('msg', $params)) {
        throw new Exception("You must add message to the params array!");
      } else {
        $this->message = $params['msg'];
      }

      if(array_key_exists('rule', $params)) {
        $this->_rule = $params['rule'];
      }

      try {
        $this->success = $this->runValidation();
      } catch(Exception $e) {
        //echo 'Validation exception on: ' . get_class() . ', message: ' $e->getMessage();
      }
    }

    abstract public function runValidation();
  }
