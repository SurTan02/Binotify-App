<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
   
        if (isset($_GET['song_id'])) {
            $songId = $_GET['song_id'];
            // $query = $db_connection->prepare("SELECT * FROM \"user\"");
            // $query = $db_connection->prepare("SELECT * FROM song WHERE song_id = '$songId'");
            // $query->execute();
            
            // $result = $query->fetch(PDO::FETCH_ASSOC);
            // foreach ($result as $publisher) {
            //     echo $publisher['email'] . '<br>';
            // }
            // $tes =  json_encode($result);
            // echo $tes;
        }

        $lagu = new Song($songId);
        $result = $lagu->getSongById($songId, $db_connection);

        if (!$result){
            // Page 404
        } else{
            $detail_lagu_html = file_get_contents('./../../public/html/detail_lagu.html');
            $detail_lagu_html = str_replace('{judul_lagu}', $result['judul'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{penyanyi}', $result['penyanyi'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{tanggal_terbit}', $result['tanggal_terbit'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{genre}', $result['genre'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{durasi}', $result['duration'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{audio_path}', "../../" . $result['audio_path'] . ".mp3", $detail_lagu_html);
            
            echo $detail_lagu_html;
        }
    // if(!empty($_POST["add_record"])) {
    //     require_once("koneksi.php");
    //     // $sql = "INSERT INTO song ( song_id, Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path ) VALUES ( :post_title, :description, :post_at )";
    //     $sql = "INSERT INTO \"user\" ( user_id, email, password, username, isAdmin ) VALUES ( :userID, :email, :katasandi, :username, false )";
    //     $pdo_statement = $pdo_conn->prepare( $sql );
            
    //     $result = $pdo_statement->execute( array( ':userID'=>$_POST['userID'], ':email'=>$_POST['email'], ':katasandi'=>$_POST['katasandi'],':username'=>$_POST['username'] ) );
    //     if (!empty($result) ){
    //         header('location:index.php');
    //     }
    // }
    
?>
