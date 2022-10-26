<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';
    $idUser = validateAuthCookie($_COOKIE);
    $user = new User();
    $isAdmin = $user->getRoleById($idUser);
    $username = $user->getUsernameById($idUser);
    
    // if session["login"] is not set, use guest header
    $isSetSession = isset($_SESSION["login"]);
    $header_html = getHeader($isAdmin, $isSetSession, $username);

    $head_html = file_get_contents('./view/html/templates/head.html');

    $head_html = str_replace('{css1}', '/view/css/components/header.css', $head_html);    
    $head_html = str_replace('{css2}', '/view/css/detail_lagu.css', $head_html);
    
    // BODY HTML 
    $detail_lagu_html = file_get_contents('./view/html/detail_lagu.html');
    $foot_html = file_get_contents('./view/html/templates/foot.html');

    $content_page_html;
        if (isset($_GET['song_id'])) {
            $songId = $_GET['song_id'];

            // Get Song with id - song_id
            $lagu = new Song();
            $result = $lagu->getSongById($songId);

            if($result){
                $header_html = str_replace('{title}', "Brisic - " . $result['judul'], $header_html);
                $detail_lagu_html = str_replace('{judul_lagu}', $result['judul'], $detail_lagu_html);
                $detail_lagu_html = str_replace('{penyanyi}', $result['penyanyi'], $detail_lagu_html);
                $detail_lagu_html = str_replace('{tanggal_terbit}', $result['tanggal_terbit'], $detail_lagu_html);
                $detail_lagu_html = str_replace('{genre}', $result['genre'], $detail_lagu_html);
                $detail_lagu_html = str_replace('{album}', $result['album_id'], $detail_lagu_html);
                $detail_lagu_html = str_replace('{audio_path}',  $result['audio_path'] , $detail_lagu_html);
                $detail_lagu_html = str_replace('{image_path}',  $result['image_path'] , $detail_lagu_html);

                if ($result['album_id']){
                    $detail_lagu_html = str_replace('{judul_album}',  $result['judul_album'] , $detail_lagu_html);
                }else{
                    $detail_lagu_html = str_replace('{judul_album}',  '' , $detail_lagu_html);
                }
            
                // Edit Config
                if ($isAdmin){
                    $foot_html = str_replace('{js1}', './view/js/edit_lagu.js', $foot_html);
                }
                $content_page_html =  $detail_lagu_html;
            }
            else{
                $header_html = str_replace('{title}', "404", $header_html);
                $content_page_html =  "404";
            }
        } else{
            $header_html = str_replace('{title}', "404", $header_html);
            $content_page_html =  "404";
        }
        echo $head_html;
        echo $header_html;
        echo $content_page_html; 
        echo $foot_html;
?>
