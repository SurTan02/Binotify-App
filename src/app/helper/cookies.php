<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../models/User.php";

// issueCookie
function issueAuthCookie($user_id){
  $cookie_name = COOKIE_AUTH;
  $exp = time() + (60 * 60 * 24); // 1 days
  $cookie_value = $id . "-" . $exp;

  // encode the cookie by base 64
  $cookie_value_encoded = base64_encode($cookie_value);
  // add secret 
  $cookie_secret = $cookie_value . "-" . COOKIE_AUTH_SECRET;
  // hash the cookie
  $cookie_secret_hashed = hash("sha256", $cookie_secret);

  // set the cookie
  $cookie_value_secret = $cookie_value_encoded . "-" . $cookie_secret_hashed;
  setcookie($cookie_name, $cookie_value_secret, $exp, "/");
}

// validateCookie
function validateAuthCookie($all_cookie){
  if (!isset($all_cookie[COOKIE_AUTH])) {
    return false;
  }

  $cookie = $all_cookie[COOKIE_AUTH];
  $cookie_split = explode(".", $cookie);
  $cookie_value_encoded = $cookie_split[0];
  $cookie_secret_hashed = $cookie_split[1];

  // decode the cookie
  $cookie_value = base64_decode($cookie_value_encoded);

  // Validate that the cookie is valid by checking its secret.
  $cookie_secret = $cookie_value . "-" . COOKIE_AUTH_SECRET;

  // Hash the cookie secret.
  $cookie_secret_hashed_validate = hash('sha256', $cookie_secret);

  // Check if the cookie secret is valid.
  if ($cookie_secret_hashed_validate !== $cookie_secret_hashed) {
    return false;
  }
   // Split the cookie by -.
   $cookie = explode("-", $cookie_value);

   // Get the user id.
   $id = $cookie[0];
 
   // Get the cookie expire time.
   $exp = $cookie[1];
 
   // Check if the cookie is expired.
   if (empty($id) || time() > $exp) {
     return false;
   }
 
   // Check if user id is valid.
   $userDB = new User();
   $user = $userDB->getUserById($id);
   if (empty($user)) {
     return false;
   }
   $userDB = null;
 
   // Return the id if the cookie is valid.
   return $id;
}

function removeCookie() {
  // Set the cookie name for auth.
  $cookie_name = COOKIE_AUTH;

  // Set the the cookie expire time.
  $exp = time() - COOKIE_AUTH_TIME;

  // Set the cookie value.
  $cookie_value = "";

  // Encode the cookie by base 64.
  $cookie_value = base64_encode($cookie_value);

  // Set the cookie to the user.
  setcookie($cookie_name, $cookie_value, $exp, "/");
}
?>