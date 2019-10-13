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
      //dnd($_SESSION);
      $this->view->render('home/index');
    }
  }
