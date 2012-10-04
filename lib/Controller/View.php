<?php
include('Error.php');

class View
{
   protected $args;

   public function __construct($view, $method, $get)
   {
      $this->handleView($view);
      $this->handleMethod($view, $method);
      $this->handleArguments($get);
   }

   protected function handleView($view)
   {
      (class_exists($view)) ? Stream::$view = new ReflectionClass($view) : Stream::jump(404);
   }

   protected function handleMethod($view, $method)
   {
      ($this->methodExists($method)) ? Stream::$method = new ReflectionMethod($view, $method) : Stream::jump(405);
   }

   protected function handleArguments($get)
   {
      if(!empty($get)) Stream::$get = $get;
      $this->args = $this->getArguments();
      return (!$this->missingArgs($get)) ? : Stream::jump(400);
   }

   protected function methodExists($method)
   {
      return Stream::$view->hasMethod($method);
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
      $arguments = Stream::$method->getParameters();
      return (sizeof($arguments)>0) ? $arguments : null;
   }
}
