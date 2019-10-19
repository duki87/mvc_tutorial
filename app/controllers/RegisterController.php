<?php

  class RegisterController extends Controller
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
            'required'  =>  true,
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
          } else {
            $validation->addError('There is an error with your username or password!');
            $this->view->displayErrors = $validation->displayErrors();
          }
        } else {
          $this->view->displayErrors = $validation->displayErrors();
        }
      }
      $this->view->render('register/login');
    }

    public function logout()
    {
      if(Users::currentLoggedInUser()) {
        Users::currentLoggedInUser()->logout();
      }
      Router::redirect('register/login');
    }

    public function register()
    {
      $validation = new Validate();
      $postedValues = Input::formInputs(['fname', 'lname', 'email', 'password', 'confirm']);
      if($_POST) {
        $postedValues = Input::formInputs($_POST);
        //form validation
        $validation->check($_POST, [
          'fname' => [
            'display' => 'First Name',
            'required'  => true
          ],
          'lname' => [
            'display' => 'Last Name',
            'required'  => true
          ],
          'username'  =>  [
            'display'   =>  'Username',
            'required'  =>  true,
            'unique'  => 'users',
            'min' =>  6,
            'max' =>  150
          ],
          'email'  =>  [
            'display'   =>  'Email',
            'required'  =>  true,
            'unique'  => 'users',
            'validEmail' =>true
          ],
          'password'  =>  [
            'display'   =>  'Password',
            'required'  =>  true,
            'min' => 6
          ],
          'confirm'  =>  [
            'display'   =>  'Confirm',
            'required'  =>  true,
            'matches' => 'password'
          ]
        ]);
        if($validation->passed()) {
          $newUser = new Users();
          $newUser->register($_POST);
          $newUser->login();
          Router::redirect('');
        }
      }
      $this->view->displayErrors = $validation->displayErrors();
      $this->view->post = $postedValues;
      $this->view->render('register/register');
    }
  }
