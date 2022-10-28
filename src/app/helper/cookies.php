<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php';

/**
 * This function is used to issue auth cookie and set the cookie.
 * @param $id
 */ 
function issueAuthCookie($id) {
  $cookie_name = COOKIE_AUTH;
  $exp = time() + COOKIE_AUTH_TIME;
  $cookie_value = $id . "-" . $exp;
  $cookie_value_encoded = base64_encode($cookie_value);
  $cookie_secret = $cookie_value . "-" . COOKIE_AUTH_SECRET;
  $cookie_secret_hashed = hash('sha256', $cookie_secret);
  $cookie_value_secret = $cookie_value_encoded . "." . $cookie_secret_hashed;
  setcookie($cookie_name, $cookie_value_secret, $exp, "/");
}


/** 
  * This function is used to validate auth cookie,
  * @param $all_cookie
  * @return $id
  */
function validateAuthCookie($all_cookie){
  if (!isset($all_cookie[COOKIE_AUTH])) {
    return false;
  }
  $cookie = $all_cookie[COOKIE_AUTH];
  $cookie_split = explode(".", $cookie);
  $cookie_value_encoded = $cookie_split[0];
  $cookie_secret_hashed = $cookie_split[1];
  $cookie_value = base64_decode($cookie_value_encoded);
  $cookie_secret = $cookie_value . "-" . COOKIE_AUTH_SECRET;
  $cookie_secret_hashed_validate = hash('sha256', $cookie_secret);
  if ($cookie_secret_hashed_validate !== $cookie_secret_hashed) {
    return false;
  }   $cookie = explode("-", $cookie_value);
  $id = $cookie[0];
  $exp = $cookie[1];
  if (empty($id) || time() > $exp) {
    return false;
   }
  $userDB = new User();
  $user = $userDB->getUserById($id);
  if (empty($user)) {
    return false;
  }
  $userDB = null;
  return $id;
}


/**
 * this function is used to remove auth cookie.
 */
function removeCookie() {
  $cookie_name = COOKIE_AUTH;
  $exp = time() - COOKIE_AUTH_TIME;
  $cookie_value = "";
  $cookie_value = base64_encode($cookie_value);
  setcookie($cookie_name, $cookie_value, $exp, "/");
}
?>