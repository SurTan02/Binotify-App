<?php
    require_once './app/controller/search.php'; // $genres
    
    $header_html = file_get_contents('./view/html/components/header_admin.html');
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Spotify', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
    $head_html = str_replace('{css2}', './view/css/search.css', $head_html);
    $head_html = str_replace('{css3}', './view/css/components/card_filter_genre.css', $head_html);

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
    // echo
    echo $head_html;
    // echo $header_html;
    echo $search_html;
?>