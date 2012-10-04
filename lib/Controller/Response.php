<?php
class Response
{
   public static $view;
   public static $method;
   public static $get = array();

   public $options;

   public function __construct()
   {
      new View();
   }

   public static function downStream()
   {
      $class = self::$view->newInstance();
      self::$method->invokeArgs($class, self::$get);
   }

   public static function jump($error)
   {
      self::$view = new ReflectionClass('Error');
      self::$method = new ReflectionMethod('Error', 'http');
      self::$get[0] = $error;
      exit;
   }
}
