<?php
require_once('Request.php');
require_once('Response.php');
require_once('View.php');
require_once('Template.php');
require_once('Error.php');

function has_http_get($path)
{
   return (substr($path,0,1)==="?");
}

register_shutdown_function(function() {
   Response::downStream();
});

new Request();
