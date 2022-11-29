<?php
/* put your process here:
 * query the database
 * get session, etc.
*/ 
session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
    

    $idUser = validateAuthCookie($_COOKIE);
    $arr = [
        "id_user" => $idUser
    ];

// 👇 when done, echo the data
echo json_encode($arr);