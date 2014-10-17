<?php

require_once "classes/FaceRecognitionClass.php";

$face = new Face();

switch($method) {
  case 'uploadFace':
      $face->uploadFace();
      break;
}

?>