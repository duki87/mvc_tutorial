<?php

  class Router
  {
    public static function route($url)
    {
      //grab controller name from the url
      $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
      $controller_name = str_replace('Controller', '', $controller);
      array_shift($url); //removes first element of the array, the controller name

      //grab method name from the url
      $action = (isset($url[0]) && $url[0] != '') ? $url[0] : DEFAULT_ACTION;
      $action_name = $action;
      array_shift($url); //removes first element of the array, now it is the action name

      //ACL check
      $grantAccess = self::hasAccess($controller_name, $action_name);
      if(!$grantAccess) {
        Session::addSessionMessage(
          'danger', 
          'You are not allowed to access requested page. Login <a href="'.SITE_ROOT.'register/login">here</a> to grant access.', 
          'Warning!'
        );
        self::back();
/*         $controller = ACCESS_RESTRICTED.'Controller';
        $controller_name = ACCESS_RESTRICTED;
        $action = 'index'; */
      }

      //url params
      $queryParams = $url;
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

    public static function back()
    {
      if(isset($_SERVER["HTTP_REFERER"])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      } else { 
        echo '<script type="text/javascript">';
        echo 'history.back();';
        echo '</script>';
        exit();
      }
      exit();
    }

    public static function hasAccess($controller_name, $action_name = 'index')
     {
       $aclFile = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
       $acl = json_decode($aclFile, true);
       $currentUserAcls = ['Guest'];
       $grantAccess = false;
       if(Session::exists(CURRENT_USER_SESSION_NAME)) {
         $currentUserAcls[] = 'LoggedIn';
         foreach(Users::currentUser()->acls() as $a) {
           $currentUserAcls[] = $a;
         }
       }
       foreach($currentUserAcls as $key) {
         if($acl[$key] === null) continue;
         if(array_key_exists($key, $acl) && array_key_exists($controller_name, $acl[$key])) {
           if(in_array($action_name, $acl[$key][$controller_name]) || in_array("*", $acl[$key][$controller_name])) {
             $grantAccess = true;
             break;
           }
         }
       }
       //check for denied
       foreach($currentUserAcls as $key) {
         if(!array_key_exists($key, $acl)) {
           continue;
         }
         $denied = $acl[$key]['denied'];
         if($denied === null) continue;
         if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
           $grantAccess = false;
           break;
         }
       }
       return $grantAccess;
     }

    public static function getMenu($menu)
    {
      $menuArray = [];
      $menuFile = file_get_contents(ROOT . DS . 'app' . DS . $menu . '.json');
      $acl = json_decode($menuFile, true);
      foreach($acl as $key => $value) {
        if(is_array($value)) {
          $submenu = [];
          foreach($value as $subKey => $subValue) {
            if($subKey == 'separator' && !empty($submenu)) {
              $submenu[$subKey] = '';
              continue;
            } else if($finalValue = self::getLink($subValue)) {
              $submenu[$subKey] = $finalValue;
            } else {
              //$sub[$subKey] = self::getLink($subValue);
            }
          }
          if(!empty($submenu)) {
            $menuArray[$key] = $submenu;
          }
        } else {
          if($finalValue = self::getLink($value)) {
            $menuArray[$key] = $finalValue;
          }
        }
      }
      return $menuArray;
    }

    private static function getLink($item)
    {
      //Check if it is external link
      if(preg_match('/https?:\/\//', $item) == 1) {
        return $item;
      } else {
        $e = explode('/', $item);
        $controller_name = ucwords($e[0]);
        $action_name = (isset($e[1])) ? $e[1] : '';
        if(self::hasAccess($controller_name, $action_name)) {
          return SITE_ROOT . $item;
        }
        return false;
      }
    }
  }
