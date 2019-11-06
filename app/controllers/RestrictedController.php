<?php

  class RestrictedController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
    }

    public function index()
    {
      $this->view->render('restricted/index');
    }

    public function bad_token()
    {
      $this->view->render('restricted/bad-token');
    }
  }
