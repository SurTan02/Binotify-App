<?php 
  session_start();

  session_destroy();
  session_unset();

  // Import cookies module.
  require_once './app/helper/cookies.php';
  removeCookie();

  // Redirect to login page.
  header('Location: ./login.php');
?>