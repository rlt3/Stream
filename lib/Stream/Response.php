<?php
class Response extends Request
{
   private $options;

   public function __construct()
   {
      new View();
   }

   public static function downStream()
   {
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
