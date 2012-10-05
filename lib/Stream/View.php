<?php
class View extends Response
{
   protected $args;
   
   public function __construct()
   {
      $this->handleView();
      $this->handleMethod();
      $this->handleArguments();
   }

   protected function handleView()
   {
      if(class_exists(Request::$view))
         parent::$view = new ReflectionClass(Request::$view);
      else
         self::jump(404);
   }

   protected function handleMethod()
   {
      if(parent::$view->hasMethod(Request::$method))
         parent::$method = new ReflectionMethod(parent::$view->getName(), Request::$method);
      else
         self::jump(405);
   }

   protected function handleArguments()
   {
      $this->args = parent::$method->getParameters();
      if(empty($this->args))
         self::jump;
      elseif($this->missingArgs(Request::$get))
         self::jump(400);
   }

   protected function missingArgs($get)
   {
      $i=0;
      foreach($this->args as $arg)
         if(!$arg->isOptional() && empty($get[$i++]))
            return true;
      return false;
   }
}
