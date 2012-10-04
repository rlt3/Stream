<?php
class View extends Response
{
   protected $args;

   public function __construct()
   {
      $this->handleView(Request::$view);
      $this->handleMethod(Request::$view, Request::$method);
      $this->handleArguments(Request::$get);
   }

   protected function handleView($view)
   {
      (class_exists($view)) ? parent::$view = new ReflectionClass($view) : parent::jump(404);
   }

   protected function handleMethod($view, $method)
   {
      ($this->methodExists($method)) ? parent::$method = new ReflectionMethod($view, $method) : parent::jump(405);
   }

   protected function handleArguments($get)
   {
      if(!empty($get)) parent::$get = $get;
      $this->args = $this->getArguments();
      return (!$this->missingArgs($get)) ? : parent::jump(400);
   }

   protected function methodExists($method)
   {
      return parent::$view->hasMethod($method);
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
      $arguments = parent::$method->getParameters();
      return (sizeof($arguments)>0) ? $arguments : exit;
   }
}
