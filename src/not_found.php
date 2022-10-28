<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';

// Get the user's id.
$idUser = validateAuthCookie($_COOKIE);

$user = new User();
$isAdmin = $user->getRoleById($idUser);
$username = $user->getUsernameById($idUser);

// if session["login"] is not set, use guest header
$isSetSession = isset($_SESSION["login"]);
$header_html = getHeader($isAdmin, $isSetSession, $username);


$head_html = file_get_contents('./view/html/templates/head.html');
$not_found_html = file_get_contents("view/html/not_found.html");
$foot_html = file_get_contents('./view/html/templates/foot.html');
  
// Replace any variables in the html files.
$head_html = str_replace('{title}', '404: Not Found', $head_html);
$head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
$head_html = str_replace('{css2}', './view/css/not_found.css', $head_html);


echo $head_html;
echo $header_html;
echo $not_found_html;


echo $foot_html;