<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';
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

    // $head_html = str_replace('{css1}', '/view/css/components/header.css', $head_html);    
    $header_html = str_replace('{css2}', '/view/css/detail_lagu.css', $header_html);
    
    // BODY HTML 
    $detail_lagu_html = file_get_contents('./view/html/detail_lagu.html');
    $foot_html = file_get_contents('./view/html/templates/foot.html');

    $content_page_html;
    if (isset($_GET['song_id'])) {
        $songId = $_GET['song_id'];

        // Get Song with id - song_id
        $lagu = new Song();
        $album = new Album();
        $result = $lagu->getSongById($songId);

        if($result){
            $header_html = str_replace('{title}', "Brisic - " . $result['judul'], $header_html);
            $detail_lagu_html = str_replace('{judul_lagu}', $result['judul'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{penyanyi}', $result['penyanyi'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{tanggal_terbit}', $result['tanggal_terbit'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{genre}', $result['genre'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{album}', $result['album_id'], $detail_lagu_html);
            $detail_lagu_html = str_replace('{audio_path}',  $result['audio_path'] , $detail_lagu_html);

            $daftar_album = ($album->getAlbumByPenyanyi($result['penyanyi']));

            $result['image_path'] == '' ? $img = "view/assets/img/default.png" : $img = $result['image_path'];
            $detail_lagu_html = str_replace('{image_path}',  $img , $detail_lagu_html);

            if ($result['album_id']){
                $detail_lagu_html = str_replace('{judul_album}',  $result['judul_album'] , $detail_lagu_html);
            }else{
                $detail_lagu_html = str_replace('{judul_album}',  '' , $detail_lagu_html);
            }
            // Edit Config
            $daftar_album = ($album->getAlbumByPenyanyi($result['penyanyi']));
            // var_dump($daftar_album);
            if ($isAdmin){
                $option = '<option value="">-</option>';
                foreach($daftar_album as $album){
                    if ($result['album_id'] == $album['album_id']){
                        $temp = '<option value= '.$album['album_id'].'>'  .$album['judul']. '</option>' . $option;
                        $option = $temp;
                    }else{
                        $option .= '<option value= '.$album['album_id'].'>'  .$album['judul']. '</option>';
                    }
                }
                $detail_lagu_html = str_replace('{option}',  $option , $detail_lagu_html);
                $foot_html = str_replace('{js1}', '/view/js/edit_lagu.js', $foot_html);
            } else{
                
                
                
                if(isset($_SESSION["number"]) && !$isSetSession){
                    if ($_SESSION['number'] >= 3){
                        $js_script =  '/view/js/cant_lagu.js' ;
                    } else{
                        $js_script =  '/view/js/play_lagu.js';
                    }
                    $foot_html = str_replace('{js1}', $js_script, $foot_html);
                }

                
            }
            $content_page_html =  $detail_lagu_html;
        }
        else{
            header("location: /not_found.php");
        }
    } else{
        header("location: /not_found.php");
    }
    echo $header_html;
    echo $content_page_html; 
    echo $foot_html;
?>
