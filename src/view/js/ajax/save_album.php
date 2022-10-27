<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST["id"])      ||
            isset($_POST["judul"])   ||
            isset($_POST["genre"])   ||
            isset($_POST["tanggal"]) ||
            isset($_POST["deleteIds"])
            ) {

            $response = 200;

            $image_path;
            if (isset($_FILES['file'])) {
                if ( 0 < $_FILES['file']['error']  && 4 != $_FILES['file']['error']) {
                    $response = 502;
                    die($response);
                } else {
                    $image_path = 'view/assets/img/' . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/'.$image_path);
                }
            } 

            $id = $_POST["id"];
            $judul = $_POST["judul"];
            $genre = $_POST["genre"];
            $tanggal = $_POST["tanggal"];
            
            $deletedIds = $_POST["deleteIds"];

            $deletedIds = json_decode(stripslashes($deletedIds));
            
            require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

            $db_album = new Album();
            if (empty($image_path)) {
                $album_results = $db_album->updateAlbumWithoutImage($id, $judul, $tanggal, $genre);
            } else {
                $album_results = $db_album->updateAlbum($id, $judul, $image_path, $tanggal, $genre);
            }

            if (!$album_results) {
                $response = 500;
                die($response);
            }

            $db_song = new Song();
            foreach ($deletedIds as $id) {
                $song_results = $db_song->setAlbumIDtoNull($id);
                if (!$song_results) {
                    $response = 500;
                    die($response);
                }
            }

            echo $response;

        } else {
            // Bad Request
            echo 400;
        }
    } else {
        // Bad Request
        echo 404;
    }
?>