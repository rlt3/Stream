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

   public static function jump($error)
   {
      self::$view = new ReflectionClass('Error');
      self::$method = new ReflectionMethod('Error', 'http');
      self::$get[0] = $error;
      exit;
   }
}
