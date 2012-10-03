<?php
class Response
{
   public $class;
   public $method;
   public $options;
   
   protected $_view;

   public function __construct($request)
   {
      $this->_view = new View($request->view, $request->method, $request->get);
   }

   protected function _routingMode()
   {
   }
}
