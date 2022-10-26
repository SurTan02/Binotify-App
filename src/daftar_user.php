<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';


$idUser = validateAuthCookie($_COOKIE);


$user = new User();
$isAdmin = $user->getRoleById($idUser);
$username = $user->getUsernameById($idUser);

if ($isAdmin != 1) {
  header("location: ./index.php");
  exit;
}

// if session["login"] is not set, use guest header
$isSetSession = isset($_SESSION["login"]);
$header_html = getHeader($isAdmin, $isSetSession, $username);

$head_html = file_get_contents('./view/html/templates/head.html');

$head_html = str_replace('{title}', 'Spotify', $head_html);
$head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
$head_html = str_replace('{css2}', './view/css/daftar_user.css', $head_html);


$daftar_user_html = file_get_contents('./view/html/daftar_user.html');




echo $head_html;
echo $header_html;
echo $daftar_user_html;
echo '<script src="./view/js/daftar_user.js"></script>';
