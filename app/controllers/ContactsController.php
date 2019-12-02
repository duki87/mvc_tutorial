<?php

  namespace App\Controllers;
  use Core\Controller;
  use App\Models\Users;
  use App\Models\Contacts;
  use Core\Validate;
  use Core\Input;
  use Core\Session;
  use Core\Router;
  use Core\H;

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
      $user_id = Users::currentUser()->id;
      $contacts = $this->ContactsModel->findContactsById($user_id, ['order' => 'lname, fname']);
      $this->view->contacts = $contacts;
      $this->view->render('contacts/index');
    }

    public function add()
    {
      $validate = new Validate();
      if($this->request->isPost()) {
        $validate::check([
          'fname'    =>  ['required' => true, 'max' => 155],
          'lname'    =>  ['required' => true, 'max' => 155],
          'email'    =>  ['required' => true, 'validEmail' => true, 'uniqueEmail' => true],
          'address'    =>  ['required' => true, 'min' => 5, 'max' => 155],
          'city'    =>  ['required' => true, 'min' => 2, 'max' => 155],
          'zip'    =>  ['required' => true, 'numeric' => true],
          'phone'    =>  ['required' => true, 'numeric' => true]
        ]);
        if($validate->passed()) {
          $newContact = new Contacts();
          $newContact->assign($this->request->get());
          $newContact->save();
          Session::addSessionMessage('success', 'Contact added.', 'Success!');
          Router::redirect('contacts');
        }
      }
      $this->view->render('contacts/add');
    }

    public function details($user_id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId($user_id, Users::currentUser()->id);
      if(!$contact) {
        Router::redirect('contacts');
      }
      $this->view->contact = $contact;
      $this->view->render('contacts/details');
    }

    public function delete($user_id)
    {
      $contact = $this->ContactsModel->findUserByIdAndUserId($user_id, Users::currentUser()->id);
      if($contact->id) {
        $contact->delete();
        Session::addSessionMessage('success', 'Contact successfully deleted.', 'Success!');
      }
      Router::redirect('contacts');
    }

    public function edit($contact_id)
    {
      if($contact_id) {
        $contact = $this->ContactsModel->findUserByIdAndUserId($contact_id, Users::currentUser()->id);
        if(!$contact->id) {
          Session::addSessionMessage('danger', 'Contact do not exist.', 'Error!');
          Router::redirect('contacts');
        }
      }
      if($this->request->isGet()) {
        Input::setPreviousValues($contact);
      }
      $validate = new Validate();
      if($this->request->isPost()) {
        $validate::check([
          'fname'    =>  ['required' => true, 'max' => 155],
          'lname'    =>  ['required' => true, 'max' => 155],
          'email'    =>  ['required' => true, 'validEmail' => true, 'uniqueEmail' => true],
          'address'    =>  ['required' => true, 'min' => 5, 'max' => 155],
          'city'    =>  ['required' => true, 'min' => 2, 'max' => 155],
          'zip'    =>  ['required' => true, 'numeric' => true],
          'phone'    =>  ['required' => true, 'numeric' => true]
        ]);
        if($validate->passed()) {
          $contact->assign($this->request->get());
          $contact->update();
          Session::addSessionMessage('success', 'Contact data successfully updated.', 'Success!');
          Router::redirect('contacts');
        }
      }
      $this->view->contact = $contact;
      $this->view->render('contacts/edit');
    }

    public function update()
    {

    }

  }
