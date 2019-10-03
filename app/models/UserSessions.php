<?php

  class UserSessions extends Model
  {
    public function __construct()
    {
      $table = 'user_sessions';
      parent::__construct($table);
    }

    public static function getFromCookie()
    {
      $userSession = new self();
      if(Cookie::exists(REMEMBER_ME_COOKIE)) {      
        $userSession = $userSession->findFirst([
          'conditions'    =>  ['user_agent', 'session'],
          'bind'          =>  [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE)]
        ]);
      }
      if(!$userSession) {
        return false;
      }
      return $userSession;
    }
  }
