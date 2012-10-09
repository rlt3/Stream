<?php
class View extends Response
{
   protected $models;
   protected $parameters;

   public function __construct()
   {
      $this->handleView();
      $this->handleMethod();
      $this->parseArguments();
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

   protected function parseArguments()
   {
      $arguments = parent::$method->getParameters();

      if(empty($arguments))
         self::jump;
      
      foreach($arguments as $argument)
         if($argument->getClass()!=null)
            $this->models[] = $argument;
         else
            $this->parameters[] = $argument;

      $this->handleArguments();
   }

   protected function handleArguments()
   {
      $i=0;
      foreach($this->parameters as $parameter)
         if($parameter->isOptional()==false && empty(Request::$get[$i++]))
            self::jump(400);

      foreach($this->models as $model)
         try {
            array_unshift(parent::$get, $model->getClass()->newInstance());
         }  catch(Exception $e) {
            self::jump(500);
         }
   }
}
