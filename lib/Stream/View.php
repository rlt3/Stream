<?php
class View extends Response
{
   public function __construct()
   {
      $this->handleView();
      $this->handleMethod();
      $this->handleParameters();
   }

   protected function handleView()
   {
      try {
         parent::$view = new ReflectionClass(Request::$view);
      }  catch(Exception $e) {
         self::jump(404);
      }
   }

   protected function handleMethod()
   {
      try {
         parent::$method = new ReflectionMethod(parent::$view->name, Request::$method);
      }  catch(Exception $e) {
         self::jump(405);
      }
   }

   protected function handleParameters()
   {
      if(parent::$method->getNumberOfRequiredParameters() == 0)
         self::jump;
      parent::$args = parent::$method->getParameters();
      $this->handleArguments(Request::$get);
   }

   protected function handleArguments($get)
   {
      for($i=0;$i<=sizeof(parent::$args);$i++)
      {
         if(parent::$args[$i]->getClass()!=null)
         {
            try {
               array_unshift(parent::$get, parent::$args[$i]->getClass()->newInstance());
            }  catch(Exception $e) {
               self::jump(500);
            }
         }
         else
            if(!parent::$args[$i]->isOptional() && empty(parent::$get[$i]))
               self::jump(400);
      }
   }
}
