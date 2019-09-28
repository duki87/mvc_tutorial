<?php

  class Controller extends Application
  {
    protected $_controller, $_action;
    public $view;

      public function __construct($controller, $action)
      {
        //Call magic construct method from parent class
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View();
      }

      protected function load_model($model)
      {
         if(class_exists($model, false)) {
            $this->{$model.'Model'} = new $model(strtolower($model));
         }
      }
  }
