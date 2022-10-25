<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
    class Song {
        private $table; 
        private $db; 
        private $song_id; 

        public function __construct($song_id) {
            $this->table = "song";
            $this->db = new Database();
            $this->song_id = $song_id;
        }

        public function getSongById() {
            try{
                $query = $this->db->query("SELECT * FROM $this->table WHERE song_id = '$this->song_id'");
                $result = $this->db->single_result();
                
                if ($result["album_id"]){
                    $query = $this->db->query("SELECT * FROM $this->table LEFT JOIN (
                        SELECT album_id, judul as judul_album from album
                    )as A USING(album_id) WHERE song_id = '$this->song_id'");
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
            if (!isset($data['edit_title']) || !isset($data['edit_penyanyi']) || 
                !isset($data['edit_genre']) || !isset($data['edit_tanggal'])  ||
                !isset($data['edit_album']) || !isset($data['edit_audio_path']) ||
                !isset($data['edit_image_path'])) {
                
                return false;
            }

            try{
                $this->db->query("UPDATE song set   title = :title, penyanyi=:penyanyi, genre=:genre
                                                    tanggal=:tanggal, album=:album, audio_path=:audio_path
                                                    image_path=:image_path
                                  WHERE song_id = $this->song_id");
                $this->db->bind(':title', $data['edit_title']);
                $this->db->bind(':penyanyi', $data['edit_penyanyi']);
                $this->db->bind(':genre', $data['edit_genre']);
                $this->db->bind(':tanggal', $data['edit_tanggal']);
                $this->db->bind(':album', $data['edit_album']);
                $this->db->bind(':audio_path', $data['edit_audio_path']);
                $this->db->bind(':image_path', $data['edit_image_path']);
                $this->db->execute();
                
                // $result = $this->db->single_result();
                // return $result;
            }catch(Error $e){
                echo $e;
            }
        }
    }
?>