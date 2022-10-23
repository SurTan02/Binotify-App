<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';

//ajax for username validation
if(isset($_GET['username'])){
  //get username
  $username = $_GET['username'];
  //create user object
  $user = new User();
  //check if username is available
  $result = $user->isValidUsername($username);
  if($result){
    echo "true";
  }
  else{
    echo "false";
  }
}

// ajax for email validation
if(isset($_GET['email'])){
  //get email
  $email = $_GET['email'];
  //create user object
  $user = new User();
  //check if email is available
  $result = $user->isValidEmail($email);
  if($result){
    echo "true";
  }
  else{
    echo "false";
  }
}

?>