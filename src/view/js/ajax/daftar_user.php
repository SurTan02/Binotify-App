<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
        
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';

        $db = new User();

        $user_results = $db->getAllUser($page);

        header('Content-Type: application/json');
        echo json_encode($user_results);
        }
    }
?>