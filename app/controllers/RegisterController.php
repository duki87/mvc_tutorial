<?php

  class RegisterController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action); //if load_model doesn't work, then change the order of parent constructor and load_model
      $this->load_model('Users');
      $this->view->setLayout('default');
    }

    public function logout()
    {
      if(Users::currentUser()) {
        Users::currentUser()->logout();
      }
      Router::redirect('register/login');
    }

    public function register()
    {
      $validate = new Validate();
      if($this->request->isPost()) {
        $validate::check([
          'fname'    =>  ['required' => true],
          'lname'    =>  ['required' => true],
          'username' =>  ['required' => true, 'min' => 6, 'max' => 10, 'uniqueUsername' => true],
          'email'    =>  ['required' => true, 'validEmail' => true, 'uniqueEmail' => true],
          'password' =>  ['required' => true, 'min' => 6, 'passwordMatches' => 'confirm']
        ]);
        if($validate->passed()) {
          $newUser = new Users();
          $newUser->assign($this->request->get());
          $newUser->password = Hash::make($newUser->password);
          $newUser->save();
          Router::redirect('register/login');
        }
      }
      $this->view->render('register/register');
    }

    public function login()
    {
      $validation = new Validate();
      if($this->request->isPost()) {
        $validate::check([
          'username' =>  ['required' => true],
          'password' =>  ['required' => true]
        ]);
      }
      if($this->request->isPost()) {
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
        ], true);
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
  }
