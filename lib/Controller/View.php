<?php
include('Error.php');

class View
{
   protected $view;
   protected $method;
   protected $get;
   protected $args;

   public function __construct($view, $method, $get)
   {
      $this->handleView($view);
      $this->handleMethod($view, $method);
      $this->handleArguments($get);
   }

   public function invoke()
   {
      $view = $this->view->newInstance();
      ($this->get==null) ? $this->method->invoke($view) : $this->method->invokeArgs($view, $this->get);
   }

   protected function handleView($view)
   {
      (class_exists($view)) ? $this->view = new ReflectionClass($view) : $this->error(404);
   }

   protected function handleMethod($view, $method)
   {
      ($this->methodExists($method)) ? $this->method = new ReflectionMethod($view, $method) : $this->error(405);
   }

   protected function handleArguments($get)
   {
      $this->args = $this->getArguments();
      return (!$this->missingArgs($get)) ? : $this->error(400);
   }

   protected function methodExists($method)
   {
      return $this->view->hasMethod($method);
   }

   protected function missingArgs($get)
   {
      $i=0;
      foreach($this->args as $arg)
         if(!$arg->isOptional() && empty($get[$i++]))
            return true;
      return false;
   }

   protected function getArguments()
   {
      $arguments = $this->method->getParameters();
      return (sizeof($arguments)>0) ? $arguments : null;
   }

   private final function error($error)
   {
      $this->view = new ReflectionClass('Error');
      $this->method = new ReflectionMethod('Error', 'http');
      $this->args = $this->method->getParameters;
      $this->get[0] = $error;
      $this->invoke();
      exit;
   }
}
