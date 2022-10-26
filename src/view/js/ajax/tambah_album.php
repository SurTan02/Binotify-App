<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';
    
    // ADD LAGU
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $album = new Album();

        $data = array(
            "title"=>$_POST["title"],
            "penyanyi"=>$_POST["penyanyi"],
            "genre"=>$_POST["genre"],
            "tanggal"=>$_POST["tanggal"],
            "image_path"=>$_POST["image_path"],
        );
        
        $result = $album->addAlbum($data);
        echo ($result);
    }
?>