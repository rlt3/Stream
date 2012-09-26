<?php
include('Views/Views.php');

class Controller
{
   private $_requestMethod;
   private $_requestURL;
   private $_url;
   private $_view;
   private $_method;
   private $_methodArgs;
   private $_urlParams;
   private $_params;

   function __construct()
   {
      $this->_requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
      $this->_requestURL    = $_SERVER['REQUEST_URI'];
      $this->_url           = $this->explodeURL();
      $this->_view          = $this->handleView();
      $this->_method        = $this->handleMethod();
      $this->_methodArgs    = $this->handleArguments();
      $this->_urlParams     = $this->handleGetParameters();
      $this->_params        = $this->handleParameters();
   }

   function __destruct()
   {
      $this->displayView();
   }

   private function explodeURL()
   {
      return explode('/', $this->_requestURL);
   }

   private function handleView()
   {
      if($this->_requestURL === '/')
         $this->_url[0] = 'index';

      if($this->viewExists($this->_url[0]))
            return new $this->_url[0];
      header('Location: /404');
   }

   private function handleMethod()
   {
      if($this->methodExists($this->_view, $this->_requestMethod))
         return $method = new ReflectionMethod($this->_url[0], $this->_requestMethod);
      header('Location: /404');
   }

   private function handleArguments()
   {
      return (sizeof($this->_method->getParameters())>0) ? $this->_method->getParameters() : null;
   }

   private function handleGetParameters()
   {
      $array = array_slice($this->_url, 2);
      return $array;
   }

   private function handleParameters()
   {
      $i=0;
      foreach($this->_methodArgs as $arg)
      {
         if(!$arg->isOptional() && empty($this->_urlParams[$i]))
            header('Location: /404');
         $params[] = $this->_urlParams[$i++];
      }
      return $params;
   }

   private function displayView()
   {
      if($this->_params == null || empty($this->_params[0]))
         $this->_method->invoke($this->_view);
      else
         $this->_method->invokeArgs($this->_view, $this->_params);
   }

   private function viewExists($view)
   {
      return class_exists(ucfirst($view));
   }

   private function methodExists($view, $method)
   {
      return method_exists($view, $method); 
   }
}
$remote = new Controller();
