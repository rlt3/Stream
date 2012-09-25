<?php
include('Views/Views.php');

class Controller
{
   protected $_method;
   protected $_request;
   private   $_url;     // the url split by / into an array
   protected $_params;
   protected $_view;

   function __construct()
   {
      $this->_method  = strtolower($_SERVER['REQUEST_METHOD']);
      $this->_request = $_SERVER['REQUEST_URI'];
      $this->_view    = $this->handleRequest();
      $this->_params  = $this->handleParameters();
   }

   function __destruct()
   {
      $method = new ReflectionMethod($this->_view, $this->_method);
      if($this->_params == null)
         $method->invoke($this->_view);
      else
         $method->invokeArgs($this->_view, $this->_params);
   }

   private function handleRequest()
   {
      if($this->_request === '/')
         return $view = new Index();

      if($this->_request === '/404')
         return $view = new Error(404);

      // if the request is /page/, redirect to /page
      if(substr_compare($this->_request, '/', strlen($this->_request)-1) == 0)
         return header('Location: '.substr($this->_request,0,-1));

      $this->_url = explode('/', $this->_request);

      return $view = $this->viewExists($this->_url[1]);
   }

   private function handleParameters()
   {
      $method = new ReflectionMethod($this->_view, $this->_method);
      $args = $method->getParameters();
      if(sizeof($args) == 0)
         return null;

      $get = array_slice($this->_url, 2);
      $i=0;
      foreach ($args as $arg)
         $params[] = $get[$i++];

         //echo (!$arg->isOptional) ? "true" : "false";
         //echo (empty($get[$i++])) ? "true" : "false";
         //if(!$arg->isOptional && empty($get[$i++]))
         //   header('Location: /404');

      return $params;
   }

   private function viewExists($view)
   {
      if(class_exists(ucfirst($view)))
      {
         $obj = new $view;
         if(method_exists($obj, $this->_method))
            return $obj;
      }
      header('Location: /404');
   }
}
$remote = new Controller();
