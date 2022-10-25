<?php
    $header_html = file_get_contents('./view/html/components/header_admin.html');
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Spotify', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
    $head_html = str_replace('{css2}', './view/css/search.css', $head_html);
    $head_html = str_replace('{css3}', './view/css/components/card_song.css', $head_html);

    $search_html = file_get_contents('./view/html/daftar_album.html');

    echo $head_html;
    // echo $header_html;
    echo $search_html;
    echo '<script src="./view/js/daftar_album.js"></script>';
?>