<?php
  class Home extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      //$this->
    }
    public function index()
    {
      $this->view->render('home/index');
      //die('WELCOME TO HOME CONTROLLER. <br> THIS IS index() METHOD.');
    }
  }
