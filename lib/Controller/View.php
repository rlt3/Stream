<?php
class View
{
   public $view;
   public $method;

   protected $_rClass   = false;
   protected $_rMethod  = false;
   protected $_args     = false;

   public function __construct($view, $method)
   {
      $this->view   = $view;
      $this->method = $method;
      $this->_rClass  = $this->_handleView();
      $this->_rMethod = $this->_handleMethod();
      $this->_args    = $this->_getArguments();
   }

   public function responseView()
   {
      return $this->_rClass;
   }

   public function responseMethod()
   {
      return $this->_rMethod;
   }

   public function getErrors($get)
   {
      $errors['isMissing']  =  ($this->_rClass==false) ? true : false;
      $errors['noMethod']   =   ($this->_rMethod==false) ? true : false;
      $errors['missedArgs'] = $this->missingRequiredArguments($get);
      return $errors;
   }

   public function isBadView()
   {
      /**
       * This doesn't check to see if a passed parameter exists as a method.
       * E.g. /purchases/calc uses Purchases::calc(), but if there was a request
       * for /purchases/fun, even though Purchases::fun() doesn't exist, this
       * still says the view is good.
       */
      return ($this->_rClass==false || $this->_rMethod==false) ? true : false;
   }

   public function hasArguments()
   {
      return ($this->_args!=false) ? true : false;
   }

   public function missingRequiredArguments($get)
   {
      $i=0;
      foreach($this->_args as $arg)
         if(!$arg->isOptional() && empty($get[$i++]))
            return true;
      return false;
   }

   protected function _getArguments()
   {
      $arguments = ($this->_rMethod!=false) ? $this->_rMethod->getParameters() : null;
      if(sizeof($arguments)>0)
         return $arguments;
   }

   protected function _handleView()
   {
      if($this->_viewExists())
         return new ReflectionClass($this->view);
   }

   protected function _handleMethod()
   {
      if($this->_methodExists())
         return new ReflectionMethod($this->view, $this->method);
   }

   protected function _viewExists()
   {
      return class_exists($this->view);
   }

   protected function _methodExists()
   {
      if($this->_rClass!=false)
         return $this->_rClass->hasMethod($this->method);
      return false;
   }
}
