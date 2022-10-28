<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
    

    // ADD LAGU
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $song = new Song();

        $data = array(
            "title"=>$_POST["title"],
            "penyanyi"=>$_POST["penyanyi"],
            "genre"=>$_POST["genre"],
            "tanggal"=>$_POST["tanggal"],
            "audio_path"=>$_POST["audio_path"],
            "image_path"=>$_POST["image_path"],
            "duration"=>$_POST["duration"],
        );
        
        
        $result = $song->addSong($data);
        echo ($result);
    }
?>