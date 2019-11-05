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

    public function logout()
    {
      if(Users::currentUser()) {
        Users::currentUser()->logout();
      }
      Router::redirect('register/login');
    }

    public function register()
    {
      $this->view->inputs = new Input();
      $newUser = new Users();
      if($this->request->isPost()) {
        $validate = Validate::check([
          'fname'    =>  ['required' => true],
          'lname'    =>  ['required' => true],
          'username' =>  ['required' => true, 'min' => 6, 'max' => 10, 'uniqueUsername' => true],
          'email'    =>  ['required' => true, 'validEmail' => true, 'uniqueEmail' => true],
          'password' =>  ['required' => true, 'min' => 6, 'passwordMatches' => 'confirm']
        ]);
        $this->request->csrfCheck();
        $newUser->assign($this->request->get());
        $this->view->inputs->formInputs($this->request->get());
        //$newUser->setConfirm($this->request->get('confirm'));
        // if($newUser->save()) {
        //   //$newUser->login();
        //   Session::addSessionMessage('success', 'Successfuly registered! Now you can sign in to your account.', 'Success!');
        //   Router::redirect('register/login');
        // }
      }
      //$this->view->displayErrors = $newUser->getErrorMessages();
      $this->view->newUser = $newUser;
      $this->view->render('register/register');
    }
  }
