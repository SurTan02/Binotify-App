<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';

    $head_html = file_get_contents('./view/html/templates/head.html');
    $head_html = str_replace('{title}', 'Brisic', $head_html);
    $head_html = str_replace('{css1}', '../view/css/detail_lagu.css', $head_html);
    
    // BODY HTML 
    $detail_lagu_html = file_get_contents('./view/html/detail_lagu.html');
    $foot_html = file_get_contents('./view/html/templates/foot.html');
   
        if (isset($_GET['song_id'])) {
            $songId = $_GET['song_id'];
        }
        
        $lagu = new Song($songId);
        
        $result = $lagu->getSongById($songId);
        if (!$result){
            // Page 404
        } else{
            $detail_lagu_html = str_replace('{judul_lagu}', $result['judul'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{penyanyi}', $result['penyanyi'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{tanggal_terbit}', $result['tanggal_terbit'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{genre}', $result['genre'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{durasi}', $result['duration'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{audio_path}',  $result['audio_path'] . ".mp3", $detail_lagu_html);
            
            
            // Echo the page page.
            echo $head_html;
            echo $detail_lagu_html;
            // echo '<script src="./js/detail_lagu.js"></script>';
            echo $foot_html;
        }
?>
