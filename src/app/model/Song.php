<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
    class Song {
        private $table; 
        private $db; 

        public function __construct() {
            $this->table = "song";
            $this->db = new Database();
        }

        public function getSongById($songId) {
            try{
                $query = $this->db->query("SELECT * FROM $this->table WHERE song_id = '$songId'");
                $result = $this->db->single_result();
                
                if ($result["album_id"]){
                    $query = $this->db->query("SELECT * FROM $this->table LEFT JOIN (
                        SELECT album_id, judul as judul_album from album
                    )as A USING(album_id) WHERE song_id = '$songId'");
                    $result = $this->db->single_result();
                }
            } catch ( error $e ) {
                echo 'ERROR!';
                print_r( $e );
            }
            return $result;
        }

        // Get 10 newest inserted song
        public function getNewestSong() {
            try{
                $query = $this->db->query(" SELECT *, DATE_PART('year', Tanggal_terbit) as tahun FROM 
                                            (SELECT * FROM song ORDER BY (song_id) DESC LIMIT 10) as C 
                                            ORDER BY judul ASC");
                $result = $this->db->multi_result();
                
            } catch ( error $e ) {
                echo 'ERROR!';
                print_r( $e );
            }
            return $result;
        }

        // get song by distinct genre
        public function getSongByDistinctGenre() {
            $result;
            try {
                $query = "SELECT genre, MIN(image_path) AS image_path FROM song GROUP BY genre";
                $this->db->query($query);
                $result = $this->db->multi_result();
            } catch ( error $e ) {
                echo 'ERROR!';
                $result = NULL;
            }
            return $result;
        }

        public function getSongByJudulPenyanyiTahun($user_query, $page, $genre, $judul, $tahun) {
            $result;
            try {
                $user_query = filter_var($user_query, FILTER_SANITIZE_URL);

                $query = "SELECT COUNT(song_id) FROM song WHERE ";
                if ($genre != '') {
                    $query = $query . "LOWER(genre) = :genre AND ";
                }
                $query =  $query . 
                "(LOWER(judul) LIKE CONCAT('%', LOWER(:user_query), '%')
                OR
                LOWER(penyanyi) LIKE CONCAT('%', LOWER(:user_query), '%')
                OR
                EXTRACT(YEAR FROM tanggal_terbit) = :user_query_number)";
                $this->db->query($query);
                $this->db->bind(':user_query', $user_query);
                $this->db->bind(':user_query_number', (int) preg_replace('/\D/', '', $user_query));
                if ($genre != '') {
                    $this->db->bind(':genre', $genre);    
                }
                $result['count'] = $this->db->single_result()['count'];
                
                $query = "SELECT * FROM song WHERE ";
                if ($genre != '') {
                    $query = $query . "LOWER(genre) = :genre AND ";
                    $this->db->bind(':genre', $genre);
                }
                $query = $query . 
                "(LOWER(judul) LIKE CONCAT('%', LOWER(:user_query), '%')
                OR
                LOWER(penyanyi) LIKE CONCAT('%', LOWER(:user_query), '%')
                OR
                EXTRACT(YEAR FROM tanggal_terbit) = :user_query_number)
                ORDER BY judul " . $judul . " ";
                if ($tahun != '') {
                    $query = $query . ", tanggal_terbit " . $tahun . " ";
                }
                $query = $query . "OFFSET :page LIMIT 10";
                $this->db->query($query);
                $this->db->bind(':user_query', $user_query);
                $this->db->bind(':user_query_number', (int) preg_replace('/\D/', '', $user_query));
                $this->db->bind(':page', ($page - 1) * 10);
                if ($genre != '') {
                    $this->db->bind(':genre', $genre);    
                }
                $result['data'] = $this->db->multi_result();
            } catch ( error $e ) {
                echo $e;
                $result = NULL;
            }
            return $result;
        }

        public function editLagu($data){
            
            // Must have component
            if (!isset($data['title']) || !isset($data['tanggal'])) {
                return false;
            }
            
            $data_before = $this->getSongById($data['song_id']);
            // Set unchanged attributes
            if (!isset($data['image_path']) || ($data['image_path']) == ''){
                $data['image_path'] = $data_before['image_path'];
            }
            if (!isset($data['audio_path']) || ($data['audio_path']) == ''){
                $data['audio_path'] = $data_before['audio_path'];
            }
            if (($data['duration'] == 0)){
                $data['duration'] = $data_before['duration'];
            }

            try{
                $this->db->query("UPDATE song set   judul = :title, genre=:genre, 
                                                    tanggal_terbit=:tanggal, album_id=:album, audio_path=:audio_path, 
                                                    image_path=:image_path, duration =:duration
                                  WHERE song_id = :song_id");

                $this->db->bind(':title', $data['title']);
                $this->db->bind(':genre', $data['genre']);
                $this->db->bind(':tanggal', $data['tanggal']);
                $this->db->bind(':album', $data['album']);
                $this->db->bind(':audio_path', $data['audio_path']);
                $this->db->bind(':image_path', $data['image_path']);
                $this->db->bind(':duration', $data['duration']);
                $this->db->bind(':song_id', $data['song_id']);
                $this->db->execute();
                return true;
                // $result = $this->db->single_result();
                // return $result;
            }catch(Error $e){
                echo $e;
                return false;
            }
        }

        public function getSongsByAlbumID($album_id) {
            $result;
            try {
                $query = "SELECT * FROM song WHERE album_id = :album_id";
                $this->db->query($query);
                $this->db->bind(':album_id', $album_id);
                $result = $this->db->multi_result();
            } catch ( error ) {
                echo 'ERROR!';
                $result = NULL;
            }
            return $result;
        }

        public function setAlbumIDtoNull($id) {
            $result;
            try {
                $query = "UPDATE song SET album_id = NULL WHERE song_id = :id";
                $this->db->query($query);
                $this->db->bind(':id', $id);
                $result = $this->db->single_result();
            } catch ( error $e ) {
                echo $e;
                $result = NULL;
            }
            return $result;
        }

        public function addSong($data){
            
            // Must have component
            if (!isset($data['title']) || !isset($data['tanggal'])  ||
                !isset($data['duration']) || !isset($data['audio_path'])) {
                return false;
            } 

            try {
                $this->db->query("INSERT INTO $this->table (judul, penyanyi, genre, tanggal_terbit, album_id, audio_path, image_path, duration)
                                  VALUES (:judul, :penyanyi, :genre, :tanggal_terbit, :album, :audio_path, :image_path, :duration)");
                $this->db->bind(':judul', $data['title']);
                $this->db->bind(':penyanyi', $data['penyanyi']);
                $this->db->bind(':genre', $data['genre']);
                $this->db->bind(':tanggal_terbit', $data['tanggal']);
                $this->db->bind(':album', $data['album']);
                $this->db->bind(':audio_path', $data['audio_path']);
                $this->db->bind(':image_path', $data['image_path']);
                $this->db->bind(':duration', $data['duration']);
                
                $this->db->execute();
                return true;
            } catch (error $e) {
                //throw $th;
                return false;
            }
        }

        public function deleteSong($song_id){
            try {
                $query = "DELETE FROM $this->table 
                          WHERE song_id = :song_id";
                $this->db->query($query);
                $this->db->bind(':song_id', $song_id);
                $this->db->execute();
                return true;
            } catch ( error $e ) {
                echo 'ERROR!';
                return false;
            }
        }

    }
?>