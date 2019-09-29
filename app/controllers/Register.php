<?php

  class Register extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action); //if load_model doesn't work, then change the order of parent constructor and load_model
      $this->load_model('Users');
      $this->view->setLayout('default');
    }

    public function login()
    {
      $validation = new Validate();
      if($_POST) {
        //form validation
        $validation->check($_POST, [
          'username'  =>  [
            'display'   =>  'Username',
            'required'  =>  true
          ],
          'password'  =>  [
            'display'   =>  'Password',
            'required'  =>  true
          ]
        ]);
        if($validation->passed()) {
          $user = $this->UsersModel->findByUserName($_POST['username']);
          if($user && password_verify(Input::get('password'), $user->password)) {
            $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
            $user->login($remember);
            Router::redirect('');
          }
        }
      }
      $this->view->displayErrors = $validation->displayErrors(); 
      $this->view->render('register/login');
    }

    public function register()
    {
      $this->view->render('register/register');
    }
  }
