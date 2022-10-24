<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["query"]) && isset($_POST["genre"]) && isset($_POST["page"])) {
            $query = $_POST["query"];
            $genre = $_POST["genre"];
            $page = $_POST["page"];
        }
    
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

        $db = new Song();

        $song_results = $db->getSongByJudulPenyanyiTahun($query, $page, $genre);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($song_results);
    }

?>