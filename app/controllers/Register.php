<?php

  class Register extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      //$this->view->setLayout('default');
      //$this->load_model('Users');
      $users = new Users();
    }

    public function login()
    {
      if($_POST) {
        //form validation
        $validation = true;
        if($validation === true) {
          $user = $this->UserModel->findByUserName($_POST['username']);
          dnd($user);
        }
      }
      $this->view->render('register/login');
    }

    public function register()
    {
      $this->view->render('register/register');
    }
  }
