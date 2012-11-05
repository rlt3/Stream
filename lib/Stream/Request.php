<?php
class Request
{
   /**
    * This is the first class that gets instantiated. It is called
    * from the Stream.php file.
    *
    * This class gets the request path (/article/what-is-a-request-path), 
    * the request method (GET, POST, DELETE) and determines what view
    * is being requested (article -- the first part of the request path).
    *
    * With this information, the Request created a Response.
    */

   public static $view;
   public static $method;
   public static $get;
   private $path;

   public function __construct()
   {
      $this->_redirectSlashes();

      // make an array from stuff between slashes from request path
      $this->path   = explode('/', $_SERVER['REQUEST_URI']);

      self::$method = strtolower($_SERVER['REQUEST_METHOD']);
      self::$view   = $this->_getView();
      self::$get    = $this->_getParameters();

      new Response();
   }

   private function _getView()
   {
      return (empty($this->path[1]) || has_http_get($this->path[1])) ? 'Index' : ucfirst($this->path[1]);
   }

   private function _getParameters()
   {
      return array_slice($this->path, 2);
   }

   private function _redirectSlashes()
   {  // site.com/page/ => site.com/page
      $url = $_SERVER['REQUEST_URI'];
      if(substr_compare($url, '/', strlen($url)-1) == 0 && $url != '/')
         header('Location: '.substr($url,0,-1));
   }
}
