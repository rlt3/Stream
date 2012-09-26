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

   private $_error;

   function __construct()
   {
      $this->_requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
      $this->_requestURL    = $_SERVER['REQUEST_URI'];

      $this->redirectSlashes();
      $this->_url           = $this->explodeURL();
      $this->_view          = $this->handleView();
      $this->_method        = $this->handleMethod();
      $this->_methodArgs    = $this->handleArguments();
      $this->_urlParams     = $this->handleGetParameters();
      $this->_params        = $this->handleParameters();

      $this->handleErrors();
   }

   function __destruct()
   {
      $this->displayView();
   }

   private function redirectSlashes()
   {
      if(substr_compare($this->_requestURL, '/', strlen($this->_requestURL)-1) == 0 && $this->_requestURL != '/')
         header('Location: '.substr($this->_requestURL,0,-1));
   }

   private function explodeURL()
   {
      return explode('/', $this->_requestURL);
   }

   private function handleView()
   {
      if($this->_requestURL === '/')
         $this->_url[1] = 'index';

      if($this->viewExists($this->_url[1]))
         return new ReflectionClass($this->_url[1]);
      $this->_error[] = 404;
   }

   private function handleMethod()
   {
      if($this->methodExists($this->_view, $this->_requestMethod))
         return new ReflectionMethod($this->_url[1], $this->_requestMethod);
      $this->_error[] = 404;
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
         $params[] = $this->handleArg($arg, $this->_urlParams[$i]);
      return $params;
   }

   private function handleArg($arg, $param)
   {
      if(!$arg->isOptional() && empty($param))
         $this->_error[] = 404;
      return $param;
   }

   private function displayView()
   {
      if(!empty($this->_error))
         $this->_view = $this->_view->newInstanceArgs($this->_error);
      else
         $this->_view = $this->_view->newInstance();
      if($this->_params == null || empty($this->_params[0]))
         $this->_method->invoke($this->_view);
      else
         $this->_method->invokeArgs($this->_view, $this->_params);
   }

   private function handleErrors()
   {
      if(empty($this->_error)) return;

      $this->_params = null;
      $this->_view   = new ReflectionClass('Error');
      $this->_method = new ReflectionMethod('Error', 'get');
   }

   private function viewExists($view)
   {
      return class_exists(ucfirst($view));
   }

   private function methodExists($view, $method)
   {
      return $this->_view->hasMethod($method);
   }
}
$remote = new Controller();
