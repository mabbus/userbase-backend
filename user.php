<?php 

require_once 'classes/UserClass.php';

$user = new User();

switch($method) {
  case 'getUser':
      $user->getUserInfo($value, 'fid');
      break;
  case 'createUser':
      $user->createUser($value);
      break;
  case 'updateUser':
      $user->updateUser();
      break;
  case 'deleteUser':
      $user->deleteUser();
  default:
}

?>