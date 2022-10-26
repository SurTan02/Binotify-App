<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';

    $header_html = file_get_contents('./view/html/components/header_admin.html');
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Spotify', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);

    if (isset($_GET['album_id'])) {
        $album_id = $_GET['album_id'];

        $album = new Album();
        $album_result = $album->getAlbumById($album_id);

        $song = new Song();
        $songs_result = $song->getSongsByAlbumID($album_id);

        echo json_encode($album_result, true);
        echo json_encode($songs_result, true);
    }

    echo $head_html;
    // echo $header_html;
    // echo '<script src="./view/js/daftar_album.js"></script>';
?>
