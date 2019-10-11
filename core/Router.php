<?php

  class Router
  {
    public static function route($url)
    {
      //grab controller name from the url
      $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
      $controller_name = $controller;
      array_shift($url); //removes first element of the array, the controller name

      //grab method name from the url
      $action = (isset($url[0]) && $url[0] != '') ? $url[0] : DEFAULT_ACTION;
      $action_name = $action;
      array_shift($url); //removes first element of the array, now it is the action name

      //ACL check
      $grantAccess = self::hasAccess($controller_name, $action_name);
      if(!$grantAccess) {
        $controller_name = $controller = ACCESS_RESTRICTED;
        $action = 'index';
      }

      //url params
      $queryParams = $url;

      //$controller = ROOT . DS . 'app' . DS . 'controllers' . DS . $controller;
      $dispatch = new $controller($controller_name, $action);
      if(method_exists($controller, $action)) {
        call_user_func_array([$dispatch, $action], $queryParams);
      } else {
        die('METHOD_NOT_EXISTS');
      }
    }

    public static function redirect($location) {
      if(!headers_sent()) {
        header('Location: ' . SITE_ROOT . $location);
        exit();
      } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href ="'.SITE_ROOT.$location.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
        echo '</noscript>';
        exit();
      }
    }

    public static function hasAccess($controller_name, $action_name = 'index')
    {
      $aclFile = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
      $acl = json_decode($aclFile, true);
      $currentUserAcls = ['Guest'];
      $grantAccess = false;
      if(Session::exists(CURRENT_USER_SESSION_NAME)) {
        $currentUserAcls[] = 'LoggedIn';
        foreach(currentUser()->acls() as $a) {
          $currentUserAcls[] = $a;
        }
      }
      foreach($currentUserAcls as $key) {
        if($acl[$key] === null) continue; //added for testing
        if(array_key_exists($key, $acl) && array_key_exists($controller_name, $acl[$key])) {
          if(in_array($action_name, $acl[$key][$controller_name]) || in_array("*", $acl[$key][$controller_name])) {
            $grantAccess = true;
            break;
          }
        }
      }
      //check for denied
      foreach($currentUserAcls as $key) {
        //added for testing
        if(!array_key_exists($key, $acl)) {
          continue;
        }
        //finish added
        $denied = $acl[$key]['denied'];
        if($denied === null) continue; //added for testing
        if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
          $grantAccess = false;
          break;
        }
      }
      //dnd($currentUserAcls);
      return $grantAccess;
    }
  }
