<?php
require_once('Template.php');
require_once('Request.php');
require_once('Response.php');
require_once('Error.php');
require_once('View.php');

register_shutdown_function(function() {
   Response::downStream();
});

new Request();
