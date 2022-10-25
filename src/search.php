<?php
    require_once './app/controller/search.php'; // $genres
    
    $header_html = file_get_contents('./view/html/components/header_admin.html');
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Spotify', $head_html);
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

    $search_html = str_replace('{start}', min(1, $song_results['count']), $search_html);
    $search_html = str_replace('{stop}', min(10, $song_results['count']), $search_html);
    $search_html = str_replace('{total}', $song_results['count'], $search_html);

    $song_list = '';
    foreach ($song_results['data'] as $key=>$song) {
        $card_song_html = file_get_contents('./view/html/components/card_song.html');
        $card_song_html = str_replace('{list-number}', $key+1, $card_song_html);
        $card_song_html = str_replace('{song-image-path}', $song['image_path'], $card_song_html);
        $card_song_html = str_replace('{song-title}', $song['judul'], $card_song_html);
        $card_song_html = str_replace('{song-genre}', $song['genre'], $card_song_html);
        $card_song_html = str_replace('{song-author}', $song['penyanyi'], $card_song_html);
        $card_song_html = str_replace('{song-year}', mb_substr($song['tanggal_terbit'], 0, 4), $card_song_html);
        $song_list = $song_list . $card_song_html;
    }

    $search_html = str_replace('{song_list}', $song_list, $search_html);
    
    $total_page = ceil($song_results['count']/10);
    $pagination = '<li>←</li>';
    $pagination = $pagination . '<li class="page-active">1</li>';
    $pagination = $pagination . '<li onclick="loadSong(2)">2</li>';
    $pagination = $pagination . '<li onclick="loadSong(3)">3</li>';
    if ($total_page == 4) {
        $pagination = $pagination . '<li onclick="loadSong(' . $total_page . ')">' . $total_page . '</li>';
    }
    if ($total_page > 4) {
        $pagination = $pagination . '<li>...</li>';
        $pagination = $pagination . '<li onclick="loadSong(' . $total_page . ')">' . $total_page . '</li>';
    }
    $pagination = $pagination . '<li onclick="loadSong(2)">→</li>';

    $search_html = str_replace('{pagination}', $pagination, $search_html);
    // echo
    echo $head_html;
    // echo $header_html;
    echo $search_html;
    echo '<script src="./view/js/search.js"></script>';
?>