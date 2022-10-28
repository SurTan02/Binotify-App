<?php 
  // require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';

/**
 * This function is used to issue login session.
 */
function issueLoginSession() {
  // if (isset($_SESSION["number"])) unset($_SESSION["number"]);
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

function issueGuestSession(){
  if (!isset($_SESSION["number"])){
    $_SESSION["number"] = 0;
    $_SESSION['CREATED'] = time();
    $_SESSION['song_id'] = 0;

  }else if(time() - $_SESSION['CREATED'] > 60*60*24){
    session_unset();
  }
}

?>