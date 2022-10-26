<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $image_path;
        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }
        else {
            $image_path = 'view/assets/img/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/'.$image_path);
        }

        if (isset($_POST["id"])      ||
            isset($_POST["judul"])   ||
            isset($_POST["genre"])   ||
            isset($_POST["tanggal"]) ||
            isset($_POST["deleteIds"])
            ) {

        $id = $_POST["id"];
        $judul = $_POST["judul"];
        $genre = $_POST["genre"];
        $tanggal = $_POST["tanggal"];
        
        $deletedIds = $_POST["deleteIds"];

        $deletedIds = json_decode(stripslashes($deletedIds));
        
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

        $db_album = new Album();
        $album_results = $db_album->updateAlbum($id, $judul, $image_path, $tanggal, $genre);

        $db_song = new Song();
        foreach ($deletedIds as $id) {
            $song_results = $db_song->setAlbumIDtoNull($id);
        }

        } else {
            echo "error";
        }
    } else {
        echo "not POST";
    }
?>