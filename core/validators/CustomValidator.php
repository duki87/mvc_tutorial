<?php

  abstract class CustomValidator
  {
    public $success = true, $message = '', $field, $rule;
    protected $_model;

    public function __construct($model, $params)
    {
      //H::dnd($params);
      $this->_model = $model;
      if(!array_key_exists('field', $params)) {
        throw new Exception("You must add field to the params array!");
      } else {
        $this->field = (is_array($params['field'])) ? $params['field'][0] : $params['field'];
      }

      if(!property_exists($model, $this->field)) {
        throw new Exception("Field must exists in the model class!");
      }

      if(!array_key_exists('msg', $params)) {
        throw new Exception("You must add message to the params array!");
      } else {
        $this->message = $params['msg'];
      }

      if(array_key_exists('rule', $params)) {
        $this->rule = $params['rule'];
      }

      try {
        $this->success = $this->runValidation();
      } catch(Exception $e) {
        //echo 'Validation exception on: ' . get_class() . ', message: ' $e->getMessage();
      }
    }

    abstract public function runValidation();
  }
