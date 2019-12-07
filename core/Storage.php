<?php

  namespace Core;
  use Core\H;

  class Storage
  {

    protected $_root;

    public function __construct($root = '')
    {
      $this->_root = $root;
    }

    public static function disk($disk)
    {
      $root = self::readFS($disk);
      return new self($root);
    }

    private static function readFS($disk)
    {
      $fs = include './config/fs.php';
      if(array_key_exists('disks', $fs)) {
        if(array_key_exists($disk, $fs['disks'])) {
          return $fs['disks'][$disk]['root'];
        }
      }
    }

    public function scan($dirname)
    {
      return array_diff(scandir(ROOT . DS . $this->_root . DS . $dirname), array('..', '.'));
    }

    public function get($pathToFile)
    {
      if($this->exists($pathToFile)) {
        return ROOT . DS . $this->_root . DS . $pathToFile;
      }
    }

    public function read($pathToFile)
    {
      if($this->exists($pathToFile)) {
        return file_get_contents(ROOT . DS . $this->_root . DS . $pathToFile);
      }
    }

    public function put($file, $path)
    {
      $path = ROOT . DS . $this->_root . DS . $path;
      return file_put_contents($path, $file);
    }

    public function exists($pathToFile)
    {
      return file_exists(ROOT . DS . $this->_root . DS . $pathToFile);
    }

    public function mkdir($dirname)
    {
      mkdir(ROOT . DS . $this->_root . DS . $dirname);
    }

    public function rmdir($dirname)
    {
      if($this->exists($dirname)) {
        $files = $this->scan($dirname);
        if(!empty($files)) {
          foreach($files as $file) {
            if(is_dir(ROOT . DS . $this->_root . DS . $dirname . DS . $file)  && !is_link(ROOT . DS . $this->_root . DS . $dirname . DS . $file)) {
              $this->rmdir($dirname . DS . $file);
            } else {
              $this->delete($dirname . DS . $file);
            }
          }
        }
        rmdir(ROOT . DS . $this->_root . DS . $dirname);
      }
    }

    public function delete($pathToFile)
    {
      if($this->exists($pathToFile)) {
        unlink(ROOT . DS . $this->_root . DS . $pathToFile);
      }
    }

    public function move($pathToFile, $newPath)
    {
      if($this->exists($pathToFile)) {
        $file = $this->read($pathToFile);
        unlink(ROOT . DS . $this->_root . DS . $pathToFile);
        $this->put($file, $newPath);
      }
    }

    public function copy($pathToFile, $newPath)
    {
      if($this->exists($pathToFile)) {
        $file = $this->read($pathToFile);
        $this->put($file, $newPath);
      }
    }
  }
