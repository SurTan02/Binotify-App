<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Brisic', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
    $head_html = str_replace('{css2}', './view/css/search.css', $head_html);
    $head_html = str_replace('{css3}', './view/css/components/card_song.css', $head_html);

    $idUser = validateAuthCookie($_COOKIE);

    $user = new User();
    $isAdmin = $user->getRoleById($idUser);
    $username = $user->getUsernameById($idUser);

    // if session["login"] is not set, use guest header
    $isSetSession = isset($_SESSION["login"]);
    $header_html = getHeader($isAdmin, $isSetSession, $username);
    $search_html = file_get_contents('./view/html/daftar_album.html');

    echo $head_html;
    echo $header_html;
    echo $search_html;
    echo '<script src="./view/js/daftar_album.js"></script>';
?>