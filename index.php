<?php
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__));

  //Load configuration and helper functions
  require_once ROOT . DS . 'config' . DS . 'config.php';
  require_once ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

  //Autoload classess
  // spl_autoload_register(function($className) {
  //   if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
  //     require_once(ROOT . DS . 'core' . DS . $className . '.php');
  //   } elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
  //     require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
  //   } elseif(file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
  //     require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
  //   } else {
  //     die('CONTROLLER_NOT_EXISTS');
  //   }
  // });


  function autoload($className) {
    if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
      //echo(ROOT . DS . 'core' . DS . $className . '.php'.'<br>');
      require_once(ROOT . DS . 'core' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
      //echo(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php'.'<br>');
      require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
      echo(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php'.'<br>');
      require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
    } else {
      die('CONTROLLER_NOT_EXISTS');
    }
  }
  spl_autoload_register('autoload');

  session_start();

  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];
  //$db = DB::getInstance();

  //Route the request
  Router::route($url);
