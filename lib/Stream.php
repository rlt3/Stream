<?php
include('Controller/Controller.php');
include('Views/Template.php');
//include('Models/Database.php');

class Stream
{
   public static $view;
   public static $method;
   public static $get;

   public static function downStream()
   {
      $class = self::$view->newInstance();
      (self::$get==null) ? self::$method->invoke($class) : 
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

register_shutdown_function(function() {
   Stream::downStream();
});
