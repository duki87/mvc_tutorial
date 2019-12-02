<?php

  namespace Core;
  
  class Hash
  {
      public static function make($password)
      {
          return password_hash($password, PASSWORD_BCRYPT);
      }

      public static function makeRandomHash()
      {
          return md5(uniqid() . rand(0, 100));
      }

      public static function check($plain, $hash)
      {
          if(password_verify($plain, $hash)) {
              return true;
          }
          return false;
      }
  }
