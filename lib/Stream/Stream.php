<?php
require_once('Request.php');
require_once('Response.php');
require_once('View.php');
require_once('Template.php');
require_once('Error.php');

/**
 * This file is included from app/Controller/Controller.php
 *
 * Stream starts by handling a Request. This Request is sent all the way 'up'
 * before returning down stream to the user. The reason I made it like this is
 * that the program can actually end early, sending a response down stream to
 * the user at any point, saving time and resources.
 *
 * So, after the Request gets all the valuable information and creates a
 * Response, the Response can immediately know if the Request was bad and 404.
 * 
 * This doesn't take as much time at all compared to a Request where the
 * Reponse needs a Model and other information passed to it before returning
 * to the user.
 *
 * In this way, the things that required the most work get the most resources.
 * And the requests that can be given a response in short time are able to.
 */

function has_http_get($path)
{
   return (substr($path,0,1)==="?");
}

register_shutdown_function(function() {
   Response::downStream();
});

new Request();
