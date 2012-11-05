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

   public function __construct()
   {
      new View();
   }

   public static function downStream()
   {
      /**
       * Using the ReflectionMethod::invokeArgs() with an empty array
       * will still work if the method has no arguments. So the way we
       * invoke the method doesn't change, even if we don't have arguments.
       */
      self::$method->invokeArgs(self::$view->newInstance(), self::$get);
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
}
