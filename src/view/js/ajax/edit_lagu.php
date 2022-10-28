<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

    // ADD LAGU
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $song = new Song();

        $data = array(
            "title"=>$_POST["title"],
            "genre"=>$_POST["genre"],
            "tanggal"=>$_POST["tanggal"],
            "album"=>$_POST["album"],
            "audio_path"=>$_POST["audio_path"],
            "image_path"=>$_POST["image_path"],
            "duration"=>$_POST["duration"],
            "song_id"=>$_POST['song_id']
        );
        
        
        $result = $song->editLagu($data);
        echo ($result);
    }
?>