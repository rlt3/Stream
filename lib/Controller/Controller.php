<?php
require_once('Request.php');
require_once('View.php');

class Controller
{
   public $request;
   public $view;

   protected $_error;

   /**
    * Make a check to see if get[0] equals something like
    * ?q=blah so that get parameters can be passed without
    * passing it is one of my get parameters
    */

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
      $this->_displayView();
   }

   protected function _displayView()
   {
      if($this->_error['badView'] || $this->_error['missedArgs'])
         echo '404';
      else
         $this->view->invoke($this->request->get);
   }

   private function _redirectSlashes()
   {
      $url = $this->request->path;
      if(substr_compare($url, '/', strlen($url)-1) == 0 && $url != '/')
         header('Location: '.substr($url,0,-1));
   }
}
