<?php

  namespace Core;
  use Core\Application;

  class Controller extends Application
  {
    protected $_controller, $_action;
    public $view, $request;

      public function __construct($controller, $action)
      {
        //Call magic construct method from parent class
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->request = new Input();
        $this->view = new View();
      }

      protected function load_model($model)
      {
         $modelPath = 'App\Models\\' . $model;
         // if(class_exists($model)) {
         //    $this->{$model.'Model'} = new $model(strtolower($model));
         // }
         if(class_exists($modelPath)) {
            $this->{$model.'Model'} = new $modelPath();
         }
      }
  }
