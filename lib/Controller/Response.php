<?php
class Response
{
   public $class;
   public $method;
   public $options;
   
   protected $_view;

   public function __construct($request)
   {
      $this->_view = new View($request->view, $request->method);
      $this->_handleAndSetView($request->get);
   }

   public function invoke($parameters)
   {
      $view = $this->class->newInstance();
      ($parameters==null) ? $this->method->invoke($view) : $this->method->invokeArgs($view, $parameters);
   }

   protected function _handleAndSetView($get)
   {
      $errors = $this->_view->getErrors($get);
      switch($errors)
      {
         case ($errors['isMissing']): 
            echo '404';
            break;
         case ($errors['noMethod']):
            echo '405';
            break;
         case ($errors['missedArgs']): 
            echo '400';
            break;
         default:
            $this->class = $this->_view->responseView();
            $this->method = $this->_view->responseMethod();
            break;
      }
   }

   protected function _routingMode()
   {
      //$this->class = new Routing Mode;
      //$this->method = get;
   }
}
