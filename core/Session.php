<?php
  class Session
  {

    public static function exists($name)
    {
      return (isset($_SESSION[$name])) ? true : false;
    }

    public static function get($name)
    {
      return $_SESSION[$name];
    }

    public static function set($name, $value)
    {
      return $_SESSION[$name] = $value;
    }

    public static function delete($name)
    {
      if(self::exists($name)) {
        unset($_SESSION[$name]);
      }
    }

    public static function uagent_no_version()
    {
      $uagent = $_SERVER['HTTP_USER_AGENT'];
      $regex = '/\/[a-zA-Z0-9.]+/';
      $newString = preg_replace($regex, '', $uagent);
      return $newString;
    }

    public static function addSessionMessage($alert, $message, $info = 'Information')
    {
      $message = '
        <div class="alert alert-'.$alert.' alert-dismissible fade show" role="alert">
          <strong>'.$info.'</strong> '.$message.'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      ';
      $_SESSION['sessionMessage'] = $message;
    }

    public static function showSessionMessage()
    {
      $message = '';
      if(isset($_SESSION['sessionMessage'])) {
        $message = $_SESSION['sessionMessage'];
        unset($_SESSION['sessionMessage']);
      }
      return $message;
    }
  }
