<?php
  class ProfileController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      //$this->setLayout('default');
    }

    public function getProfile()
    {
      $this->view->render('profile/userProfile');
    }

    // public function profile()
    // {
    //   $this->view->render('profile/front');
    // }


  }
