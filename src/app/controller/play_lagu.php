<?php
    session_start();
    if (isset($_POST['var'])) {

        // Jika Session Lagu gada
        // var_dump($_SESSION['number'], $_SESSION['song_id'], $_POST['var'] );
        if (($_SESSION['song_id'] != $_POST['var'])){
            $_SESSION['number'] +=1;
            $_SESSION['song_id'] = $_POST['var'] ;
            // $_SESSION['last_time'] = time();

        // Lagu yang sama, tapi 5 menit yang lalu
        // } else if (time() - $_SESSION['last_time'] > 5*60){
        } else if (isset($_POST['isEnded'])){
            // $_SESSION['number'] +=1;
            $_SESSION['song_id'] = 0;
            // $_SESSION['last_time'] = time();
        }

        echo json_encode($_SESSION['number'], $_SESSION['song_id'], $_POST['var'] );
        
    }
?>