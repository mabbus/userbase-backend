<?php 

$service = isset($_GET['service']) ? $_GET['service'] : "";
$method = isset($_GET['method']) ? $_GET['method'] : "";
$value = isset($_GET['value']) ? $_GET['value'] : "";

//preload error handler
require_once "classes/ErrorHandlerClass.php";
require_once 'classes/MysqlClass.php';
require_once 'classes/FaceRecognitionClass.php';
require_once 'classes/UserClass.php';

//load service file only
require_once $service . '.php';

?>