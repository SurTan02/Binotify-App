<?php

  require_once __DIR__ . "../model/User.php";

  if (isset($_POST['register'])) {
    // get data from form
    $data = [
      'username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
    ];
    // create user object
    $user = new User();
    // register user
    $result = $user->registerUser($data);
    // check if user is registered
    if ($result) {
    }
  }
  
?>