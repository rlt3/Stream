<?php
class Request
{
   public $path;
   public $method;
   public $view;
   public $get = array();
   public $httpGet = false;

   protected $_splitPath;

   public function __construct()
   {
      $this->path   = $_SERVER['REQUEST_URI'];
      $this->method = strtolower($_SERVER['REQUEST_METHOD']);
      $this->view   = $this->_getView();
      $this->get    = $this->_getParameters();
      //$this->httpGet = $this->_getHttp();
   }

   protected function _getView()
   {
      $this->_splitPath = explode('/', $this->path);
      if($this->path==='/') return 'Index';
      return ucfirst($this->_splitPath[1]);
   }

   protected function _getParameters()
   {
      $params = array_slice($this->_splitPath, 2);
      if(empty($params)) return null;
      return $params;
   }
}
