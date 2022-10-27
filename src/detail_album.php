<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Song.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Album.php';

    // Get the user's id.
    $idUser = validateAuthCookie($_COOKIE);

    $user = new User();
    $isAdmin = $user->getRoleById($idUser);
    $username = $user->getUsernameById($idUser);

    // if session["login"] is not set, use guest header
    $isSetSession = isset($_SESSION["login"]);
    $header_html = getHeader($isAdmin, $isSetSession, $username);
    
    $head_html = file_get_contents('./view/html/templates/head.html');
    // Replace any variables in the html files.
    $head_html = str_replace('{title}', 'Spotify', $head_html);
    $head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);

    if (isset($_GET['album_id'])) {
        $album_id = $_GET['album_id'];

        $album = new Album();
        $album_result = $album->getAlbumById($album_id);

        $song = new Song();
        $songs_result = $song->getSongsByAlbumID($album_id);

        if ($album_result) {
            $head_html = str_replace('{css2}', './view/css/detail_album.css', $head_html);
            
            $detail_album_html = file_get_contents('./view/html/detail_album.html');
        
            $detail_album_html = str_replace('{img_path}', $album_result['image_path'], $detail_album_html);
            $detail_album_html = str_replace('{album_judul}', $album_result['judul'], $detail_album_html);
            $detail_album_html = str_replace('{album_penyanyi}', $album_result['penyanyi'], $detail_album_html);
            $detail_album_html = str_replace('{total_durasi}', gmdate('H:i:s', $album_result['total_duration']), $detail_album_html);
            $detail_album_html = str_replace('{album_genre}', $album_result['genre'], $detail_album_html);
            $detail_album_html = str_replace('{album_tanggal-terbit}', $album_result['tanggal_terbit'], $detail_album_html);
            
            $admin_control = "";
            if ($isAdmin) {
                 $admin_control = $admin_control . '<div class="detail_album-action">
                                                        <button onclick="save()">SAVE CHANGES</button>
                                                        <button onclick="deleteAlbum()">DELETE ALBUM</button>
                                                        <input
                                                        type="file"
                                                        id="image-input"
                                                        accept="image/jpeg, image/png, image/jpg"
                                                        />
                                                    </div>';
            } else {
                $detail_album_html = str_replace('<a onclick="edit(this)">✎</a>', "", $detail_album_html);
            }

            $detail_album_html = str_replace('{admin_control}', $admin_control, $detail_album_html);
            $song_list = '';
    
            foreach ($songs_result as $idx=>$song) {
                $song_list = $song_list . 
                '<tr id="song_'. $song['song_id'] .'">
                    <td style="text-align: center" class="number-container">';
                
                if ($isAdmin) {
                    $song_list = $song_list . '<span class="remove" onclick="removeSong('. $song['song_id'] .')">
                        <svg
                            fill="#000000"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 30 30"
                            width="16px"
                            height="16px"
                            style="fill: white"
                        >
                            <path
                            d="M 13 3 A 1.0001 1.0001 0 0 0 11.986328 4 L 6 4 A 1.0001 1.0001 0 1 0 6 6 L 24 6 A 1.0001 1.0001 0 1 0 24 4 L 18.013672 4 A 1.0001 1.0001 0 0 0 17 3 L 13 3 z M 6 8 L 6 24 C 6 25.105 6.895 26 8 26 L 22 26 C 23.105 26 24 25.105 24 24 L 24 8 L 6 8 z"
                            />
                        </svg>
                        </span>
                        <span class="number">'. $idx + 1 .'</span>';
                } else {
                    $song_list = $song_list . '<span>'. $idx + 1 .'</span>';
                }

                $song_list = $song_list . '</td>
                    <td style="display: flex; flex-direction: column; gap: 8px">
                        <p class="judul_lagu">'. $song['judul'] .'</p>
                        <p>'. $song['penyanyi'] .'</p>
                    </td>
                    <td style="text-align: center">'.gmdate('H:i:s', $song['duration']) .'</td>
                    </tr>';
            }
            
            $detail_album_html = str_replace('{song-list}', $song_list, $detail_album_html);

            echo $head_html;
            echo $header_html;
            echo $detail_album_html;
            echo '<script src="./view/js/detail_album.js"></script>';
        } else {
            // load page not found
            $head_html = str_replace('{css2}', './view/css/not_found.css', $head_html);
            $not_found_html = file_get_contents('./view/html/not_found.html');
            echo $head_html;
            echo $header_html;
            echo $not_found_html;
        }
    }

?>
