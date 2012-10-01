<?php
require_once('Request.php');
require_once('Response.php');
require_once('View.php');

class Controller
{
   public $request;
   public $response;

   public function __construct()
   {
      $this->request = new Request();
      $this->response = new Response($this->request);
   }

   public function __destruct()
   {
      $this->response->invoke($this->request->get);
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
