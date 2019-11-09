<?php

  class Users extends Model
  {

    public $id, $username, $email, $password, $fname, $lname, $acl, $deleted = 0;
    private $_isLoggedIn, $_sessionName, $_cookieName, $_confirm;
    public static $currentLoggedInUser = null;

    public function __construct($user = '')
    {
      $table = 'users';
      parent::__construct($table);
      $this->_sessionName = CURRENT_USER_SESSION_NAME;
      $this->_cookieName = REMEMBER_ME_COOKIE;
      $this->_softDelete = true;
      if($user != '') {
        if(is_int($user)) {
          $u = $this->_db->findFirst('users', ['conditions' => ['id'], 'bind' => [$user]], 'Users');
        } else {
          if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
            $u = $this->_db->findFirst('users', ['conditions' => ['email'], 'bind' => [$user]], 'Users');
          } else {
            $u = $this->_db->findFirst('users', ['conditions' => ['username'], 'bind' => [$user]], 'Users');
          }      
        }
        if($u) {
          foreach ($u as $key => $value) {
            $this->{$key} = $value;
          }
        }
      }
    }

    public function findByUserName($username)
    {
      return $this->findFirst(['conditions' => ['username'], 'bind' => [$username]]);
    }

    public function login($remember_me = false)
    {
      Session::set($this->_sessionName, $this->id);
      if($remember_me) {
        $hash = Hash::makeRandomHash();
        //H::dnd($hash);
        $user_agent = Session::uagent_no_version();
        Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRE);
        $fields = ['session' => $hash, 'user_agent' => $user_agent, 'user_id' => $this->id];
        //H::dnd($fields);
        $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
        $this->_db->insert('user_sessions', $fields);
      }
    }

    public function logout()
    {
      $userSession = UserSessions::getFromCookie();
      $userSession->deleteSession();
      Session::delete(CURRENT_USER_SESSION_NAME);
      if(Cookie::exists(REMEMBER_ME_COOKIE)) {
        Cookie::delete(REMEMBER_ME_COOKIE);
      }
      self::$currentLoggedInUser = null;
      return true;
    }

    public static function currentUser()
    {
      if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
        $u = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
        self::$currentLoggedInUser = $u;
      }
      return self::$currentLoggedInUser;
    }

    public static function loginFromCookie()
    {
      $userSession = UserSessions::getFromCookie();
      if($userSession->user_id != '') {
        $user = new self((int)$userSession->user_id);
        $user->login();
        return $user;
      }
    }

    public function acls()
    {
      if(empty($this->acl)) return [];
      return json_decode($this->acl);
    }

    public function setConfirm($value)
    {
      $this->_confirm = $value;
    }

    public function getConfirm()
    {
      return $this->_confirm;
    }

    public function beforeSave()
    {
      //$this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }
