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
            } catch ( eror $e ) {
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
    }
?>