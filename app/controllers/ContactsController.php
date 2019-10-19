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
      $user_id = currentUser()->id;
      $contacts = $this->ContactsModel->findUserById($user_id, ['order' => 'lname, fname']);
      $this->view->contacts = $contacts;
      $this->view->render('contacts/index');
    }

    public function add()
    {
      $validation = new Validate();
      $postedValues = Input::formInputs(['fname', 'lname', 'email', 'address', 'city', 'zip', 'phone']);
      $contact = new Contacts();
      if($_POST) {
        $postedValues = Input::formInputs($_POST);
        $validation->check($_POST, Contacts::$addValidation);
        if($validation->passed()) {
          $contact->assign($_POST);
          $contact->save();
          Router::redirect('contacts');
        }
      }
      $this->view->contact = $contact;
      $this->view->displayErrors = $validation->displayErrors();
      $this->view->post = $postedValues;
      $this->view->postAction = SITE_ROOT . 'contacts' . DS . 'add';
      $this->view->render('contacts/add');
    }

    public function details($id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId(int($id), currentUser()->id);
      dnd($contact);
      if(!$contact) {
        Router::redirect('contacts');
      }
      $this->view = $contact;
      $this->view->render('contacts/details');
    }
  }
