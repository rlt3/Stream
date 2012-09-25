<?php
class Error
{
   private $_error;

   function __construct($error)
   {
      $this->_error = $error;
   }

   function get()
   {
      echo "<h4>$this->_error</h4>";
   }
}

class Index
{
   private $_logged;
   private $_template;
   protected $_title;
   protected $_message;

   function __construct()
   {
      $this->_title = "Board";
      $this->_template = "Templates/homeView.php";
   }

   function get()
   {
      if($this->getLogin())
         $this->_message = "Welcome back!";
      else
         $this->_message = "Please login!";
   }

   private function getLogin()
   {
      return true;
   }

   function __destruct()
   {
      require_once("{$this->_template}");
   }
}

class Game
{
   public function get($method)
   {
      $this->{$method}();
   }

   function home()
   {
      echo "Home";
   }

   function away()
   {
      echo "Away";
   }

   function here()
   {
      echo "Here";
   }
}

class Login
{
   function get($error)
   {
      if(isset($error)) echo $error, "<br>";
      echo "login page";
      echo "<form action=\"/login\" method=\"POST\">\n";
      echo "<input type=\"submit\" value=\"post\" />\n";
      echo "</form>";
   }

   function post()
   {
      echo "login function";
   }
}
