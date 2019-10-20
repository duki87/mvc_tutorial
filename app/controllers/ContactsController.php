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
      $contacts = $this->ContactsModel->findContactsById($user_id, ['order' => 'lname, fname']);
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
          Session::addSessionMessage('success', 'Contact successfully created.', 'Success!');
          Router::redirect('contacts');
        }
      }
      $this->view->contact = $contact;
      $this->view->displayErrors = $validation->displayErrors();
      $this->view->post = $postedValues;
      $this->view->postAction = SITE_ROOT . 'contacts' . DS . 'add';
      $this->view->render('contacts/add');
    }

    public function details($user_id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId($user_id, currentUser()->id);
      if(!$contact) {
        Router::redirect('contacts');
      }
      $this->view->contact = $contact;
      $this->view->render('contacts/details');
    }

    public function delete($user_id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId($user_id, currentUser()->id);
      if($contact->id) {
        $contact->delete();
        Session::addSessionMessage('success', 'Contact successfully deleted.', 'Success!');
      }
      Router::redirect('contacts');
    }

    public function edit($user_id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId($user_id, currentUser()->id);
      if(!$contact->id) {
        Router::redirect('contacts');
      }
      $validation = new Validate();
      $postedValues = Input::formInputs([
        'id' => $contact->id, 'user_id' => $contact->user_id, 'fname' => $contact->fname, 'lname' => $contact->lname,
        'email' => $contact->email, 'address' => $contact->address, 'city' => $contact->city, 'zip' => $contact->zip,
        'phone' => $contact->phone, 'deleted' => $contact->deleted
      ]);
      if($_POST){
        $postedValues = Input::formInputs($_POST);
        $validation->check($_POST, Contacts::$addValidation);
        if($validation->passed()) {
          $contact->update($_POST);
          Session::addSessionMessage('success', 'Contact data successfully updated.', 'Success!');
          Router::redirect('contacts');
        }
      }
      $this->view->contact = $contact;
      $this->view->postAction = SITE_ROOT . 'contacts' . DS . 'edit' . DS . $contact->id;
      $this->view->displayErrors = $validation->displayErrors();
      $this->view->post = $postedValues;
      $this->view->render('contacts/edit');
    }

  }
