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
          $u = $this->_db->findFirst('users', ['conditions' => ['username'], 'bind' => [$user]], 'Users');
        }
        if($u) {
          foreach ($u as $key => $value) {
            $this->{$key} = $value;
          }
        }
      }
    }

    public function validator()
    {
      $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => 'First name is required!']));
      $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => 'Last name is required!']));

      $this->runValidation(new RequiredValidator($this, ['field' => 'username', 'msg' => 'Username is required!']));
      //Email
      $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => 'Email is required!']));
      $this->runValidation(new EmailValidator($this, ['field' => 'email', 'msg' => 'Email is not valid!']));
      $this->runValidation(new UniqueValidator($this, ['field' => 'email', 'msg' => 'Email must be unique! Try another one.']));
      //Username
      $this->runValidation(new MinValidator($this, ['field' => 'username', 'rule' => 6, 'msg' => 'Username must have at least 6 characters!']));
      $this->runValidation(new MaxValidator($this, ['field' => 'username', 'rule' => 10, 'msg' => 'Username must be less than 10 characters!']));
      $this->runValidation(new UniqueValidator($this, ['field' => 'username', 'msg' => 'Username must be unique! Try another one.']));
      //Password
      $this->runValidation(new MatchesValidator($this, ['field' => 'password', 'rule' => $this->_confirm, 'msg' => 'Passwords do not match!']));
      $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 6, 'msg' => 'Password must have at least 6 characters!']));
      $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => 'Password is required!']));

    }

    public function findByUserName($username)
    {
      return $this->findFirst(['conditions' => ['username'], 'bind' => [$username]]);
    }

    public function login($remember_me = false)
    {
      Session::set($this->_sessionName, $this->id);
      if($remember_me) {
        $hash = md5(uniqid() + rand(0, 100));
        $user_agent = Session::uagent_no_version();
        Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRE);
        $fields = ['session' => $hash, 'user_agent' => $user_agent, 'user_id' => $this->id];
        $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
        $this->_db->insert('user_sessions', $fields);
      }
    }

    public function register($params)
    {
      $this->assign($params);
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
      $this->deleted = 0;
      if($this->save()) {
        $this->id = $this->getLastInsertId();
        return true;
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
  }
