<?php
class View extends Response
{
   /**
    * The View handles the View class that will eventually return something
    * to the user. This Class sees if that View exists (if not, 404), if there
    * are missing arguments (if there are, 400), if the method is ok or not
    * (405 if it isn't).
    *
    * Most functions are wrapped around a try/catch clause because instantiating
    * a view requires the use of Reflection for what we're doing.
    *
    * The View will probably soon instantiate a "Constructor" class that deals
    * with the Constructor of a View.
    */

   protected $models = array();
   protected $parameters = array();

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
      //if(empty($arguments) || has_http_get(Request::$get[0]))
      if(empty($arguments))
      {
         Request::$get = array();
         self::jump();
      }
      
      foreach($arguments as $argument)
      {
         try {
            if($argument->getClass()!=null)
               $this->models[] = $argument;
            else
               $this->parameters[] = $argument;
         }  catch(Exception $e) {
            self::jump(500);
         }
      }

      $this->handleArguments();
   }

   protected function handleArguments()
   {  // check if missing required parameters: /delete/ with nothing to delete 
      $i=0;

      foreach($this->parameters as $parameter)
      {
         if($parameter->isOptional()==false && empty(Request::$get[$i++]))
            self::jump(400)
      }

      // for each model, try to load the model or 500
      foreach($this->models as $model)
         array_unshift(parent::$get, $this->checkModel($model));
   }

   protected function checkModel(ReflectionParameter $model)
   {
      try {
         return $model->getClass()->newInstance();
      }  catch(Exception $e) {
         self::jump(500);
      }
   }
}
