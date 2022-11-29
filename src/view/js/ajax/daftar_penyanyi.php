<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id_user"])) {
          $id_user = $_POST["id_user"];
    
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Subscription.php';

        $db = new Subscription();

        $user_results = $db->getSubscriptionById($id_user);

        header('Content-Type: application/json');
        echo json_encode($user_results);
        }
        
    }
?>