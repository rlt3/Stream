<?php
class Request
{
   public static $view;
   public static $method;
   public static $get;
   private $path;

   public function __construct()
   {
      $this->_redirectSlashes();

      $this->path   = explode('/', $_SERVER['REQUEST_URI']);
      self::$method = strtolower($_SERVER['REQUEST_METHOD']);
      self::$view   = $this->_getView();
      self::$get    = $this->_getParameters();

      new Response();
   }

   private function _getView()
   {
      return (empty($this->path[1]) || substr($this->path[1],0,1)==="?") ? 'Index' : ucfirst($this->path[1]);
   }

   private function _getParameters()
   {
      return array_slice($this->path, 2);
   }

   private function _redirectSlashes()
   {
      $url = $_SERVER['REQUEST_URI'];
      if(substr_compare($url, '/', strlen($url)-1) == 0 && $url != '/')
         header('Location: '.substr($url,0,-1));
   }
}
