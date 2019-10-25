<?php
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__));

  //Load configuration and helper functions
  require_once ROOT . DS . 'config' . DS . 'config.php';

  function autoload($className) {
    if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'core' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
    } else {
      die('CONTROLLER_NOT_EXISTS');
    }
  }
  spl_autoload_register('autoload');

  session_start();

  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

  if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE)) {
    Users::loginFromCookie();
  }

  //Route the request
  Router::route($url);
