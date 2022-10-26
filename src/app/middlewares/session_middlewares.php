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
?>