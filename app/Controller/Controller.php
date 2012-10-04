<?php
$path  = $_SERVER['DOCUMENT_ROOT'];

include_once($path.'/lib/Stream.php');
include_once($path.'/app/Views/Views.php');

Request::ResponseStream();
?>
