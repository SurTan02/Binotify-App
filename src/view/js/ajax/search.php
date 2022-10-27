<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["query"]) && isset($_POST["genre"]) && isset($_POST["page"]) && isset($_POST["judul"]) && isset($_POST["tahun"]) && isset($_POST["first"])) {
            $query = $_POST["query"];
            $genre = $_POST["genre"];
            $page = $_POST["page"];
            $judul = $_POST["judul"];
            $tahun = $_POST["tahun"];
            $first = $_POST["first"];
        
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

        $db = new Song();

        $song_results = $db->getSongByJudulPenyanyiTahun($query, $page, $genre, $judul, $tahun, $first);

        header('Content-Type: application/json');
        echo json_encode($song_results);
        }
    }
?>