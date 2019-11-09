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
        $validation::check([
          'username' =>  ['required' => true, 'min' => 6, 'max' => 10],
          'password' =>  ['required' => true, 'min' => 6]
        ]);
        if($validation->passed()) {
          $user = $this->UsersModel->findByUserName(($this->request->get('username')));
          if($user && Hash::check($this->request->get('password'), $user->password)) {
            $user = new Users($user->id);
            $user->login($this->request->get('remember_me'));
            Router::redirect('');
          } else {
            $validation::makeCustomError('wrongPassword', 'You have entered wrong password!');
          }         
        }    
      }
      $this->view->render('register/login');
    }
  }
