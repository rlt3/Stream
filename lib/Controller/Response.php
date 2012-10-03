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

   public function display()
   {
      $this->_view->invoke();
   }

   protected function _routingMode()
   {
      //$this->class = new Routing Mode;
      //$this->method = get;
   }
}
