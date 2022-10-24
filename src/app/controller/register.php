<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';

  // Don't permit user that already login go here.
  if (validateLoginSession()) {
    header("location: ./index.php");
    exit; 
  }
  
  
  if (isset($_POST['register'])) {
    $data = array(
      "username"=>$_POST["username"],
      "email"=>$_POST["email"],
      "password"=>$_POST["password"]
    );

    $userDB = new User();
    $res = $userDB->registerUser($data);

    if (is_numeric($res)) {
      issueAuthCookie($res);
      issueLoginSession();
      header("Location: ./index.php");
    } else {
      $message = "Cannot register the user";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
  
?>