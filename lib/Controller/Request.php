<?php
require_once('Request.php');
require_once('Response.php');
require_once('View.php');
require_once('Error.php');

class Request
{
   public static $path;
   public static $method;
   public static $view;
   public static $get;

   protected static $_splitPath;

   public static function ResponseStream()
   {
      self::$path   = $_SERVER['REQUEST_URI'];
      self::$method = strtolower($_SERVER['REQUEST_METHOD']);
      self::$view   = self::_getview();
      self::$get    = self::_getparameters();
      self::_redirectSlashes();

      new Response();
   }

   protected static function _getView()
   {
      self::$_splitPath = explode('/', self::$path);
      if(self::$path==='/') return 'Index';
      return ucfirst(self::$_splitPath[1]);
   }

   protected static function _getParameters()
   {
      $params = array_slice(self::$_splitPath, 2);
      if(empty($params)) return null;
      return $params;
   }

   protected static function _redirectSlashes()
   {
      $url = self::$path;
      if(substr_compare($url, '/', strlen($url)-1) == 0 && $url != '/')
         header('Location: '.substr($url,0,-1));
   }
}
