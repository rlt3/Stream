<?php
class Error
{
   public function http($error)
   {
      echo "Error: ", $error;
   }

   //public function __call($name, $arg)
   //{
   //   echo "Error: ", substr($name, 4);
   //}
}
