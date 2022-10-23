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
    }
?>