<?php
  use Core\Session;
  use Core\Router;
  use Core\Cookie;
  use App\Models\Users;

  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__));

  //Load configuration and helper functions
  require_once ROOT . DS . 'config' . DS . 'config.php';

  //Delete dnd when project is done
  function dnd($data)
  {
    echo '<pre>';
      var_dump($data);
    echo '</pre>';
    exit();
  }

  function autoload($className) {
    $classArray = explode('\\', $className);
    $class = array_pop($classArray);
    $subPath = strtolower(implode(DS, $classArray));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)) {      
      require_once($path);
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
