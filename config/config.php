<?php
  define('DEBUG', true); //define debug
  define('SITE_ROOT', '/framework/'); //define site root
  define('DEFAULT_CONTROLLER', 'Home'); //define default controller if there isn't defined in the url
  define('DEFAULT_ACTION', 'index'); //define default method if there isn't defined in the url
  define('DEFAULT_LAYOUT', 'default'); //define default; if no layout is set in controller, use this one
  define('SITE_TITLE', 'Framework'); //define site title
  define('CURRENT_USER_SESSION_NAME', 'xjkwWFLLadAwWEFlVLlEesqa'); //session name for logged in user
  define('REMEMBER_ME_COOKIE', 'ajkwWFLvdAwWEFlVLlEebAUi'); // cookie name for logged in user
  define('REMEMBER_COOKIE_EXPIRE', 604800); //expire time in seconds for remember me cookie - 7 days
  define('ACCESS_RESTRICTED', 'Restricted'); //define restricted constant for restricted redirect

  //DB constants
  define('DB_NAME', 'framework');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
  define('DB_HOST', '127.0.0.1');
