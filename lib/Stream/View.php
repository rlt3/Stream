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

   private $arguments    = array();
   protected $models     = array();
   protected $parameters = array();

   public function __construct()
   {
      $this->handleView();
      $this->handleConstructor();
      $this->handleMethod();
      $this->checkMethodArguments();
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

   protected function handleConstructor()
   {
      $constructor = parent::$view->getConstructor();
      if($constructor==NULL) return;

      $params = $constructor->getParameters();
      foreach($params as $param)
         parent::$constructModels[] = $this->checkModel($param);
   }

   protected function handleMethod()
   {  // see if Request Method was valid or 405
      try {
         parent::$method = new ReflectionMethod(parent::$view->name, Request::$method);
      }  catch(Exception $e) {
         self::jump(405);
      }
   }

   protected function checkMethodArguments()
   {
      $this->arguments = parent::$method->getParameters();

      if(empty($this->arguments))
      {
         Request::$get = array();
         self::jump();
      }
   }

   protected function parseArguments()
   {
      $i=0;
      foreach($this->arguments as $argument)
      {
         if($this->getClassName($argument)==null)
            $this->parameters[] = $this->checkArgument($argument, Request::$get[$i++]);
         else
            $this->models[] = $this->checkModel($argument);
      }

      foreach($this->models as $model)
         array_unshift(parent::$get, $model);
   }

   protected function getClassName(ReflectionParameter $param)
   {
      preg_match('/\[\s\<\w+?>\s([\w]+)/s', $param->__toString(), $matches);
      return isset($matches[1]) ? $matches[1] : null;
   }

   protected function checkArgument(ReflectionParameter $argument, $get)
   {
      if($argument->isOptional()==false && empty($get))
         self::jump(400);
      return $argument;
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
