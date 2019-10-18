<?php

  class ContactsController extends Controller
  {
    public function __construct($controller, $action)
    {
      parent::__construct($controller, $action);
      $this->load_model('Contacts');
      $this->view->setLayout('default');
    }

    public function index()
    {
      $contacts = $this->ContactsModel->findUserById(currentUser()->id, ['order' => 'lname, fname']);
      $this->view->contacts = $contacts;
      $this->view->render('contacts/index');
    }

    public function add()
    {
      $validation = new Validate();
      $postedValues = Input::formInputs(['fname', 'lname', 'email', 'address', 'city', 'zip', 'phone']);
      $contact = new Contacts();
      if($_POST) {
        $validation->check($_POST, Contacts::$addValidation);
        if($validation->passed()) {
          $contact->assign($_POST);
          $contact->save();
          Route::redirect('/contacts/index');
        }
      }
      $this->view->contact = $contact;
      $this->view->displayErrors = $validation->displayErrors();
      $this->view->post = $postedValues;
      $this->view->postAction = SITE_ROOT . 'contacts' . DS . 'add';
      $this->view->render('contacts/add');
    }
  }
