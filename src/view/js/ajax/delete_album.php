<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["id"])) {

            $id = $_POST["id"];
            
            require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';

            $db_album = new Album();
            $album_results = $db_album->deleteAlbum($id);
            
            if ($album_results) {
                echo 200;
            } else {
                echo 400;
            }
        
        } else {
            echo 400;
        }
    } else {
        echo 400;
    }
?>