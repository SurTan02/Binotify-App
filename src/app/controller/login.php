<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';

// Don't permit user that already login go here.
if (validateLoginSession()) {
     header("location: ./index.php");
     exit; 
}


if (isset($_POST["login"])) {
     // set data that have been inserted
     $data = array(
          "username"=>$_POST["username"],
          "password"=>$_POST["password"],
     );

     $userDB = new User();

     // validate login attempt
     $res = $userDB->isLoginValid($data);

     //check if success
     if ($res) {
          //issue the cookie.
          issueAuthCookie($res);
          //issue the session.
          issueLoginSession();
          //redirect to dashboard.
          header("Location: index.php");
     }
     else {
          $message = "Incorrect username / password combination";
          echo "<script type='text/javascript'>alert('$message');</script>";
     }

     $userDB = null;
}

?>