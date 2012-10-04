<?php
class Response
{
   public $class;
   public $method;
   public $options;
   
   protected $_view;

   public function __construct($view, $method, $get)
   {
      $this->_view = new View($view, $method, $get);
   }

   protected function _routingMode()
   {
   }
}
