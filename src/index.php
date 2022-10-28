<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';

// Get the user's id.
$idUser = validateAuthCookie($_COOKIE);

$user = new User();
$isAdmin = $user->getRoleById($idUser);
$username = $user->getUsernameById($idUser);

// if session["login"] is not set, use guest header
$isSetSession = isset($_SESSION["login"]);
$header_html = getHeader($isAdmin, $isSetSession, $username);


$head_html = file_get_contents('./view/html/templates/head.html');
$home_html = file_get_contents("view/html/home.html");
$foot_html = file_get_contents('./view/html/templates/foot.html');
  
// Replace any variables in the html files.
$head_html = str_replace('{title}', 'Brisic', $head_html);
$head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
$head_html = str_replace('{css2}', './view/css/home.css', $head_html);
$head_html = str_replace('{css3}', './view/css/components/card_song.css', $head_html);
  

$song = new Song();
$songs = $song->getNewestSong();
$collection_of_song_card ='';

$number = 1;
foreach ($songs as $song){
  $collection_of_song_card .= generateSongCard($song, $number);
  $number++;
}
$home_html = str_replace('{card_component}', $collection_of_song_card, $home_html);

// echo json_encode([$collection_of_song_card]);
echo $head_html;
echo $header_html; 
echo $home_html;
echo $foot_html;

function generateSongCard($song, $number) {
  $song_card_html = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/view/html/components/card_song.html");
  $song_card_html = str_replace('{song_id}', $song['song_id'], $song_card_html);
  $song_card_html = str_replace('{song-title}', $song['judul'], $song_card_html);
  $song_card_html = str_replace('{song-author}', $song['penyanyi'], $song_card_html);
  $song_card_html = str_replace('{song-year}', $song['tahun'], $song_card_html);
  $song_card_html = str_replace('{song-genre}', $song['genre'], $song_card_html);
  // $song_card_html = str_replace('{durasi}', $song['duration'], $song_card_html);
  $song['image_path'] == '' ? $img = "view/assets/img/default.png" : $img = $song['image_path'];
  $song_card_html = str_replace('{song-image-path}', $img, $song_card_html);
  $song_card_html = str_replace('{song_id}', $song['song_id'], $song_card_html);
  $song_card_html = str_replace('{list-number}', $number, $song_card_html);
  

  return $song_card_html;
}

?>