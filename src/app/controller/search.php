<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

    $COLORS = array('rgba(39, 134, 107, 255)', 'rgb(32,52,100)', 'rgba(142,103,172,255)', 'rgba(233,16,91,255)', 'rgba(19,138,9,255)');
    
    $db = new Song();
    
    $genre_results = $db->getSongByDistinctGenre();
    
    $genres = array((object) ['genre_title' => 'All', 
                              'genre_background_color' => $COLORS[rand(0,count($COLORS)-1)],
                              'genre' => '', 
                              'isChecked' => 'checked', 
                              'genre_img_path' => './view/assets/img/genre_placeholder.jpeg']);
                              
    if (isset($genre_results)) {
        foreach ($genre_results as $genre_result) {
            $genres[] = (object) ['genre_title' => ucfirst($genre_result['genre']), 
                                  'genre_background_color' => $COLORS[rand(0,count($COLORS)-1)],
                                  'genre' => strtolower($genre_result['genre']), 
                                  'isChecked' => '', 
                                  'genre_img_path' => $genre_result['image_path']];
        }
    }

    $song_results = $db->getSongByJudulPenyanyiTahun();
?>