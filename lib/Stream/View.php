<?php
class View extends Response
{
   protected $args;
   
   public function __construct()
   {
      $this->handleView();
      $this->handleMethod();
      $this->handleParameters();
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

   protected function handleParameters()
   {
      if(parent::$method->getNumberOfRequiredParameters() == 0)
         self::jump;
      $this->args = parent::$method->getParameters();
      $this->handleArguments(Request::$get);
   }

   protected function handleArguments($get)
   {
      for($i=0;$i<=sizeof($this->args);$i++)
         if(!$arg[$i]->isOptional() && empty($get[$i]))
            self::jump(400);
   }
}
