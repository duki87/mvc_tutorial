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

      //url params
      $queryParams = $url;

      //$controller = ROOT . DS . 'app' . DS . 'controllers' . DS . $controller;
      $dispatch = new $controller($controller_name, $action);
      if(method_exists($controller, $action)) {
        call_user_function_array([$dispatch, $action], $queryParams);
      } else {
        die('METHOD_NOT_EXISTS');
      }
    }
  }
