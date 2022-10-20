<?php
    $host = "db";
    $dbuser = "postgres";
    $dbpass = "postgres";
    $port = "5432";
    $dbname = "database";
    try{
        $db_connection = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);
    } catch ( PDOException $e ) {
        echo 'ERROR!';
        print_r( $e );
    }
?>