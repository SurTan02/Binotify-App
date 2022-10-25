<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
        
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';

        $db = new Album();

        $album_results = $db->getAlbums($page);

        header('Content-Type: application/json');
        echo json_encode($album_results);
        }
    }
?>