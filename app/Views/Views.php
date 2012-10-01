<?php
class Index
{
   public $title;

   function get()
   {
      new Template('indexView');
   }
}

class Remove
{
   function post($user)
   {
      echo "Deleting: $user";
   }
}

class Api
{
   function get($method)
   {
      $this->{$method}();
   }

   function getTop()
   {
      echo 'Top';
   }

   function latest()
   {
      echo 'latest';
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
