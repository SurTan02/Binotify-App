<?php
    class Song {
        private $table; 
        public function __construct() {
            
            $this->table = "song";
        }

        public function getSongById($songId, $db_connection) {
            try{
                $query = $db_connection->prepare("SELECT * FROM $this->table WHERE song_id = '$songId'");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
            } catch ( error $e ) {
                echo 'ERROR!';
                print_r( $e );
            }
            return $result;
        }
    }
?>