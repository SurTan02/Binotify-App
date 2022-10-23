<?php 
require_once __DIR__ . "/cookies.php";

// Set the login as true.
function issueLoginSession() {
  $_SESSION["login"] = true;
}

function validateLoginSession() {
  $result = validateAuthCookie($_COOKIE);
  if (!is_numeric($result)) {
    return false;
  }
  
  // Set the session if the cookie is valid.
  if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    issueLoginSession();
  }
  return true;
}
?>