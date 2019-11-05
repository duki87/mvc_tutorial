<?php

  /**
   *Form helepers class
   */
  class FH
  {
    public $formErrors = [];

    public static function inputBlock($type, $label, $name, $value, $inputAttrs = [], $divAttrs = [])
    {
        $divString = self::stringifyAttrs($divAttrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div'.$divString.'>';
        $html .= '<label for="'.$name.'">'.$label.'</label>';
        $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'" '.$inputString.'>';
        $html .= '</div>';
        return $html;
    }

    public static function stringifyAttrs($attrs)
    {
        $string = '';
        foreach($attrs as $key => $value) {
            $string .= ' '.$key.'="'.$value.'"';
        }
        return $string;
    }

    public static function submitTag($buttonText, $inputAttrs = [])
    {
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<input type="submit" value="'.$buttonText.'" '.$inputString.'>';
        return $html;
    }

    public static function submitBlock($buttonText, $inputAttrs = [], $divAttrs = [])
    {
        $divString = self::stringifyAttrs($divAttrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div'.$divString.'>';
        $html .= '<input type="submit" value="'.$buttonText.'" '.$inputString.'>';
        $html .= '</div>';
        return $html;
    }

    public static function generateToken()
    {
      $token = base64_encode(openssl_random_pseudo_bytes(32));
      Session::set('csrf_token', $token);
      return $token;
    }

    public static function checkToken($token)
    {
      return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
    }

    public static function csrfInput()
    {
      return '<input type="hidden" value="'.self::generateToken().'" id="csrf_token" name="csrf_token">';
    }

    public static function sanitize($dirty)
    {
      return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
    }

    public static function displayErrors($errors)
    {
      if(empty($errors)) {
        return '';
      }
      $html = '<div class="alert alert-danger" role="alert"><ul class="">';
      foreach ($errors as $field => $error) {
        $html .= '<li class="">'.$error.'</li>';
        $html .= '<script>$(document).ready(function(){ $("#'.$field.'").addClass("is-invalid"); });</script>';
      }
      $html .= '</div></ul>';
      Session::delete('formErrors');
      return $html;
    }

  }
