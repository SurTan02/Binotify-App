<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();

    $creator_id = $_POST["creator_id"];
    $subscriber_id = $_POST["subscriber_id"];
    $status = $_POST["status"];
    
    try {
        $query = "UPDATE subscription SET status = :status WHERE creator_id = :creator_id AND subscriber_id = :subscriber_id";
        $db->query($query);
        $db->bind(':status', $status);
        $db->bind(':creator_id', $creator_id);
        $db->bind(':subscriber_id', $subscriber_id);
        $success = $db->execute();
        echo $success;
    } catch (Exception $e) {
        echo 'ERROR: ' .$e->getMessage();
    }
} 

?>