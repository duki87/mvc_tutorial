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
  }
