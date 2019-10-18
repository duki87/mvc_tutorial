<?php

  class Contacts extends Model
  {
    public function __construct()
    {
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = true;
    }

    public function findUserById($user_id, $userParams = [])
    {
      $params = [
        'conditions'  => ['user_id'],
        'bind'        => [$user_id]
      ];
      foreach($userParams as $key => $value) {
        $params['conditions'][] = $key;
        $params['bind'][] = $value;
      }
      return $this->find($conditions);
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
