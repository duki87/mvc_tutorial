<?php
  //Load configuration and helper functions
  require_once ROOT . DS . 'config' . DS . 'config.php';
  require_once ROOT . DS . 'core' . DS . 'Router.php';
  require_once ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

  //Autoload classess
  spl_autoload_register(function($className) {
    if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'core' . DS . $className . '.php');
    } elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
      require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
    } else {
      die('sdfsfd');
    }
  });

  //Route the request
  Router::route($url);
