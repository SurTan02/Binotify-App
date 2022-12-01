<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
    require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/Subscription.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Brisic', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
    $head_html = str_replace('{css2}', './view/css/daftar_lagu_premium.css', $head_html);
    $head_html = str_replace('{css3}', './view/css/components/card_song.css', $head_html);

    $idUser = validateAuthCookie($_COOKIE);

    $user = new User();
    $isAdmin = $user->getRoleById($idUser);
    $username = $user->getUsernameById($idUser);

    // if session["login"] is not set, use guest header
    $isSetSession = isset($_SESSION["login"]);
    $header_html = getHeader($isAdmin, $isSetSession, $username);
    
    $daftar_lagu = file_get_contents('./view/html/daftar_lagu_premium.html');
    $song_player = file_get_contents('./view/html/components/play_song.html');
    
    // get penyanyi
    try {
      if (isset($_GET['penyanyi'])) {
      
        $creator_id = $_GET['penyanyi'];
        $api_url = 'http://binotify-rest-service-app:8080/song/' . $creator_id . "/"  . $idUser;
        // Read JSON file
        @$json_data = file_get_contents($api_url);
        
        if ($json_data == FALSE){
          header("location: /not_found.php");
        }
        // Decode JSON data into PHP array
        $song_data = json_decode($json_data);
        // All user data exists in 'data' object
         $response_data;
        // $song_data = $json_data;
        $song_list_html = "";
        $number = 1;
        
        $daftar_lagu = str_replace('{nama_penyanyi}', $song_data[0]->name , $daftar_lagu);
        foreach ($song_data as $song) {
            $found = false;
                    $song_list_html = $song_list_html . 
                        "<li
                        class='list-song'
                      >
                        <div class='song'>
                          <span>$number</span>
                          <div class='song-information1'>
                            <span class='song-title'>$song->judul</span>
                          </div>
                          <div class='song-information2'>
                            <button onclick='myFunction(\"$song->judul\",\"$song->audio_path\")'>CLICK</button>
                          </div>
                        </div>
                      </li>
                      ";
            $number += 1;
        }
        $song_list_html = $song_list_html . $song_player;
        $daftar_lagu = str_replace('{card_component}', $song_list_html, $daftar_lagu);
      } else{
          header("location: /not_found.php");
      }
    } catch (error $e) {
      
      header("location: /not_found.php");
    }
    
    echo $head_html;
    
    echo $header_html;
    echo $daftar_lagu;
    echo '<script src="view/js/play_song.js"></script>';
?>