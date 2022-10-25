<?php

function authUser($isAdmin, $isSetSession){
  if (!$isSetSession) {
    echo "You are guest";
    return $header_html = file_get_contents('./view/html/components/header_guest.html');
  } 
  else if ($isAdmin) {
     echo "You are admin";
     return $header_html = file_get_contents('./view/html/components/header_admin.html');
   }
   // else if not admin but l
  else if ($isAdmin == false && $isSetSession)  {
     echo "You are not admin";
     return $header_html = file_get_contents('./view/html/components/header_user.html');
   }
}
?>