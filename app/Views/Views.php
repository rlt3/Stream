<?php
class Index
{
   public $title;

   function get()
   {
      new Template('indexView');
   }
}

class Login
{
   function get($error=null)
   {
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
