<?php

  namespace App\Controllers;
  use Core\Controller;
  use Core\Input;
  use Core\FH;
  use App\Models\Users;

  class ProfileController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      //$this->setLayout('default');
    }

    public function getProfile()
    {
      $user = Users::currentUser();
      Input::setPreviousValues($user);
      $this->view->render('profile/userProfile');
    }

    // public function profile()
    // {
    //   $this->view->render('profile/front');
    // }


  }
