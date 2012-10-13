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
   {  // See if the request exists or 404
      try {
         parent::$view = new ReflectionClass(Request::$view);
      }  catch(Exception $e) {
         self::jump(404);
      }
   }

   protected function handleMethod()
   {  // see if Request Method was valid or 405
      try {
         parent::$method = new ReflectionMethod(parent::$view->name, Request::$method);
      }  catch(Exception $e) {
         self::jump(405);
      }
   }

   protected function parseArguments()
   {
      $arguments = parent::$method->getParameters();

      // if the class method has no arguments or there's an httpGet, jump
      if(empty($arguments) || has_http_get(Request::$get[0]))
      {
         Request::$get = array();
         self::jump();
      }
      
      foreach($arguments as $argument)
         if($argument->getClass()!=null)
            $this->models[] = $argument;
         else
            $this->parameters[] = $argument;

      $this->handleArguments();
   }

   protected function handleArguments()
   {  // check if missing required parameters: /delete/ with nothing to delete 
      $i=0;
      foreach($this->parameters as $parameter)
         if($parameter->isOptional()==false && empty(Request::$get[$i++]))
            self::jump(400);

      // for each model, try to load the model or 500
      foreach($this->models as $model)
         try {
            array_unshift(parent::$get, $model->getClass()->newInstance());
         }  catch(Exception $e) {
            self::jump(500);
         }
   }
}
