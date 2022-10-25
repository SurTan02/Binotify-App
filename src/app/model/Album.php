<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
    
    class Album {
        private $table; 
        private $db; 

        public function __construct() {
            $this->table = "album";
            $this->db = new Database();
        }

        public function getAlbums($page) {
            $result;
            try {
                $query = "SELECT COUNT(album_id) FROM album";
                $this->db->query($query);
                $result['count'] = $this->db->single_result()['count'];

                $query = "SELECT * FROM album ORDER BY judul ASC OFFSET :page LIMIT 10";
                $this->db->query($query);
                $this->db->bind(':page', ($page - 1) * 10);
                $result['data'] = $this->db->multi_result();
            } catch ( error ) {
                echo 'ERROR!';
                $result = NULL;
            }
            return $result;
        }
    }

?>