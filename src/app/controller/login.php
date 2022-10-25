<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';

// Don't permit user that already login go here.
// TODO: pindah ke middleware
if (validateLoginSession()) {
  header("location: ./index.php");
  exit; 
}


if (isset($_POST["login"])) {
  $data = array(
    "username"=>$_POST["username"],
    "password"=>$_POST["password"],
  );
  $userDB = new User();
  $res = $userDB->isLoginValid($data);
  if ($res) {
    issueAuthCookie($res);
    issueLoginSession();
    header("Location: index.php");
  }
  else {
    $message = "Incorrect username / password combination";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  $userDB = null;
}
?>