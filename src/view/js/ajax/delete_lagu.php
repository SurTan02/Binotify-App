<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

    // ADD LAGU
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $song = new Song();

        $song_id = $_POST['song_id'];
        $result = $song->deleteSong($song_id);
        echo ($result);
    }
?>