<?php

  class H
  {
    public static function dnd($data)
    {
      echo '<pre>';
        var_dump($data);
      echo '</pre>';
      exit();
    }

    public static function currentPage()
    {
      $currentPage = $_SERVER['REQUEST_URI'];
      if($currentPage == SITE_ROOT || $currentPage == SITE_ROOT . 'home/index') {
        $currentPage = SITE_ROOT . 'home/index';
      }
      return $currentPage;
    }

    public static function getObjectProperties($object)
    {
      return get_object_vars($object);
    }

    public static function readFile($file)
    {
      $readFile = file_get_contents(ROOT . DS . 'app' . DS . $file);
      $readFile = json_decode($readFile, true);
      return $readFile;
    }
  }
