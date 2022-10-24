<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';

/**
 * This is ajax handler for validate username.
 */
if(isset($_GET['username'])){
  $username = $_GET['username'];
  $user = new User();
  $result = $user->isValidUsername($username);
  if($result){
    echo "true";
  }
  else{
    echo "false";
  }
}

/**
 * This is ajax handler for validate email.
 */
if(isset($_GET['email'])){
  $email = $_GET['email'];
  $user = new User();
  $result = $user->isValidEmail($email);
  if($result){
    echo "true";
  }
  else{
    echo "false";
  }
}
?>