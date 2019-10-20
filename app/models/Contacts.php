<?php

  class Contacts extends Model
  {
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

    public static $addValidation = [
          'fname' => [
            'display' => 'First Name',
            'required'  => true,
            'max' => 155
          ],
          'lname' => [
            'display' => 'Last Name',
            'required'  => true,
            'max' => 155
          ],
          'email'  =>  [
            'display'   =>  'Email Address',
            'required'  =>  true,
            'unique'  => 'users',
            'validEmail' =>true
          ],
          'address'  =>  [
            'display'   =>  'Address',
            'required'  =>  true
          ],
          'city'  =>  [
            'display'   =>  'City',
            'required'  =>  true
          ],
          'zip'  =>  [
            'display'   =>  'Zip Code',
            'required'  =>  true
          ],
          'phone'  =>  [
            'display'   =>  'Phone',
            'required'  =>  true
          ]
      ];
  }
