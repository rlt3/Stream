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
      $this->response->display();
   }
}
