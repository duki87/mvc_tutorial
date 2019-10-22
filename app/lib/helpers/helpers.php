<?php

  function dnd($data)
  {
    echo '<pre>';
      var_dump($data);
    echo '</pre>';
    exit();
  }

  function sanitize($dirty)
  {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
  }

  function currentUser()
  {
    return Users::currentLoggedInUser();
    exit(); //delete if makes problem
  }

  function postedValues($post)
  {
    $cleanArray = [];
    foreach ($post as $key => $value) {
      $cleanArray[$key] = sanitize($value);
    }
    return $cleanArray;
  }

  function currentPage()
  {
    $currentPage = $_SERVER['REQUEST_URI'];
    if($currentPage == SITE_ROOT || $currentPage == SITE_ROOT . 'home/index') {
      $currentPage = SITE_ROOT . 'home/index';
    }
    return $currentPage;
  }

  function getObjectProperties($object)
  {
    return get_object_vars($object);
  }
