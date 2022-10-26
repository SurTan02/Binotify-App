<?php

function getHeader($isAdmin, $isSetSession, $username){
  if (!$isSetSession) {
    $header_html = file_get_contents('./view/html/components/header_guest.html');
    $header_html = str_replace('{username}', $username, $header_html);
    return $header_html;
  } 
  else if ($isAdmin) {
    $header_html = file_get_contents('./view/html/components/header_admin.html');
     $header_html = str_replace('{username}', $username, $header_html);
     return $header_html;
   }
   // else if not admin but l
  else if ($isAdmin == false && $isSetSession)  {
     $header_html = file_get_contents('./view/html/components/header_user.html');
     $header_html = str_replace('{username}', $username, $header_html);
     return $header_html;
   }
}
?>