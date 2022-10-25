<?php 
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';

/**
 * This function is used to issue login session.
 */
 function issueLoginSession() {
  $_SESSION["login"] = true;
}

/**
 * This function is used to validate login session.
 * if valid then issue login session.
 * @return bool
 */
function validateLoginSession() {
  $result = validateAuthCookie($_COOKIE);
  if (!is_numeric($result)) {
    return false;
  }
  if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    issueLoginSession();
  }
  return true;
}
?>