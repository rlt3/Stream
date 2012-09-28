<?php
require_once('Request.php');
require_once('View.php');

class Controller
{
   public $request;
   public $view;

   protected $_error;

   public function __construct()
   {
      $this->request = new Request();
      $this->view    = new View($this->request->view, $this->request->method); 
      $this->_redirectSlashes();

      $this->_error['badView'] =  $this->view->isBadView();
      $this->_error['missedArgs'] =  $this->view->missingRequiredArguments($this->request->get);
   }

   public function __destruct()
   {
      //$this->_debug();
      $this->_displayView();
   }

   protected function _displayView()
   {
      if($this->_error['badView'] || $this->_error['missedArgs'])
         echo '404';
      else
         $this->view->invoke($this->request->get);
   }

   protected function _redirectSlashes()
   {
      $url = $this->request->path;
      if(substr_compare($url, '/', strlen($url)-1) == 0 && $url != '/')
         header('Location: '.substr($url,0,-1));
   }

   private function _debug()
   {
      echo '<pre>';
      echo 'Request Path: ', $this->request->path, "\n";
      echo 'Response View: ', $this->request->view, "\n";
      echo 'View is Bad: ', ($this->view->isBadView()) ? 'true' : 'false', "\n";
      echo 'View has args: ', ($this->view->hasArguments()) ? 'true' : 'false', "\n";
      echo 'Get Parameters: ', ($this->request->get==null) ? 'null' : print_r($this->request->get), "\n";
      echo 'Missing Required Args: ', ($this->view->missingRequiredArguments($this->request->get)) ? 'true' : 'false', "\n";
      echo '</pre>';
   }
}
