<?php
class Response extends Request
{
   /**
    * The Response extends the Request as that keeps the flow of the
    * entire program moving 'upwards' until the end, which then 
    * the Response goes back downstream.
    *
    * The Response holds the Shutdown Function (downStream) and handles
    * errors. The program can early exit from this point on with errors
    * by "jumping down stream", called by the Response::jump() method. 
    *
    * The Response instantiates the View, which handles if there are
    * any errors (404, 405, ...).
    *
    * The Response will also handle special modes like Request Mode or
    * Debugging Mode later.
    */

   private $options;
   protected static $exceptions = array();
   protected static $constructModels = array();

   public function __construct()
   {
      new View();
   }

   public static function downStream()
   {
      /**
       * The invokeArgs methods of the Reflection Class and Reflection Method
       * actually accept an empty array when no arguments are needed. There is
       * no need to check if the array is empty and then call ->invoke if true.
       */
      $class = self::$view->newInstanceArgs(self::$constructModels);
      self::$method->invokeArgs($class, self::$get);
      self::debug();
   }

   protected static function jump($error=null)
   {
      if(isset($error)) self::error($error);
      exit;
   }

   private static function error($error)
   {
      self::$view = new ReflectionClass('Error');
      self::$method = new ReflectionMethod('Error', 'http');
      self::$get[0] = $error;
   } 

   private static function debug()
   {
      echo '<br /><br /><pre>';
      echo $_SERVER['REQUEST_URI'], "\n";
      echo 'Request View: ', parent::$view->name, "\n";
      echo 'Method:       ', parent::$method->name, "\n";
      echo "Request Vars:\n";
      foreach(parent::$get as $param)
         echo "            -{$param}\n";
      echo '</pre>';
   }
}
