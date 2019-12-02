<?php

  namespace App\Models;
  use Core\Model;

  class Contacts extends Model
  {

    public $id, $user_id, $fname, $lname, $email, $address, $city, $phone, $zip, $deleted = 0;

    public function __construct()
    {
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = true;
    }

    public function findContactsById($user_id, $orderParams = [])
    {
      $params = [
        'conditions'  => ['user_id'],
        'bind'        => [$user_id],
      ];
      foreach($orderParams as $key => $value) {
        $params['order'][] = $value;
      }
      return $this->find($params);
    }

    public function findUserByIdAndUserId($contact_id, $user_id, $userParams = [])
    {
      $params = [
        'conditions'  => ['id', 'user_id'],
        'bind'        => [$contact_id, $user_id]
      ];
      foreach($userParams as $key => $value) {
        $params['conditions'][] = $key;
        $params['bind'][] = $value;
      }
      //dnd($params);
      return $this->findFirst($params);
    }

  }
