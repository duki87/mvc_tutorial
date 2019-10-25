<?php

  class Input
  {

    public static function get($input)
    {
      if(isset($_POST[$input])) {
        return FH::sanitize($_POST[$input]);
      } else if(isset($_GET[$input])) {
        return FH::sanitize($_GET[$input]);
      }
    }

    public static function formInputs($inputs = [])
    {
      foreach ($inputs as $key => $value) {
        $inputs[$key] = $value;
      }
      return $inputs;
    }
  }
