<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/middlewares/auth_middleware.php';
   
    // Get the user's id.
    $idUser = validateAuthCookie($_COOKIE);

    $user = new User();
    $isAdmin = $user->getRoleById($idUser);
    if (!$isAdmin){
        header('location:index.php');
    }
    // if session["login"] is not set, use guest header
    $isSetSession = isset($_SESSION["login"]);
    $header_html = authUser($isAdmin, $isSetSession);

    $header_html = str_replace('{css1}', '/view/css/components/header.css', $header_html);
    $header_html = str_replace('{css2}', '/view/css/tambah_lagu.css', $header_html);
    
    // BODY HTML 
    $header_html = str_replace('{title}', "Brisic - Add Song" , $header_html);
    $detail_lagu_html = file_get_contents('./view/html/detail_lagu.html');
    $content_page_html = file_get_contents('./view/html/tambah_lagu.html');
    $foot_html = file_get_contents('./view/html/templates/foot.html');
    $foot_html = str_replace('{js1}', './view/js/tambah_lagu.js', $foot_html);

        echo $header_html; 
        echo $content_page_html; 
        echo $foot_html;
?>