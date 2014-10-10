<?php 

$service = $_GET['service'];
$method = $_GET['method'];
$value = $_GET['value'];

//preload error handler
require_once "classes/ErrorHandlerClass.php";

//load service file only
require_once $service . '.php';

?>