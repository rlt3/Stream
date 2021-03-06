<?php
class Error
{
   protected $status = array( 404 => 'Page not found.',
                              405 => 'Method not allowed.',
                              400 => 'Bad request.',
                              500 => 'Server Error.');

   public function http($error)
   {
      echo "Error: ", $error, ' - ', $this->status[$error];
   }
}
