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
    }
?>