<?php
    session_start();
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

    require_once './app/controller/search.php'; // $genres
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Brisic', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
    $head_html = str_replace('{css2}', './view/css/search.css', $head_html);
    $head_html = str_replace('{css3}', './view/css/components/card_filter_genre.css', $head_html);
    $head_html = str_replace('{css4}', './view/css/components/card_song.css', $head_html);

    $search_html = file_get_contents('./view/html/search.html');
    
    $genre_list = '';
    foreach ($genres as $genre) {
        $card_filter_genre_html = file_get_contents('./view/html/components/card_filter_genre.html');
        $card_filter_genre_html = str_replace('{genre_title}', $genre->genre_title, $card_filter_genre_html);
        $card_filter_genre_html = str_replace('{genre_background_color}', $genre->genre_background_color, $card_filter_genre_html);
        $card_filter_genre_html = str_replace('{genre}', $genre->genre, $card_filter_genre_html);
        $card_filter_genre_html = str_replace('{isChecked}', $genre->isChecked, $card_filter_genre_html);
        $card_filter_genre_html = str_replace('{genre_img_path}', $genre->genre_img_path, $card_filter_genre_html);
        $genre_list = $genre_list . $card_filter_genre_html;
    }

    $search_html = str_replace('{genre_list}', $genre_list, $search_html);
    
    echo $head_html;
    echo $header_html;
    echo $search_html;
    echo '<script src="./view/js/search.js"></script>';
?>