<?php
  class ToolsController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      //$this->setLayout('default');
    }

    public function index()
    {
      $this->view->render('tools/index');
    }

    public function frontend()
    {
      $this->view->render('tools/front');
    }

    public function backend()
    {
      $this->view->render('tools/back');
    }

    public function android()
    {
      $this->view->render('tools/android');
    }

  }
