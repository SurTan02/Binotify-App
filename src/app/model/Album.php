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
        
        public function getAlbumById($id) {
            $result;
            try {
                $query = "SELECT * FROM album WHERE album_id = :album_id";
                $this->db->query($query);
                $this->db->bind(':album_id', $id);
                $result = $this->db->single_result();
            } catch ( error $e ) {
                echo 'ERROR!';
                $result = NULL;
            }
            return $result;
        }

        public function updateAlbum($id, $judul, $image_path, $tanggal_terbit, $genre) {
            $result;
            try {
                $query = "UPDATE album 
                          SET judul = :judul,  
                              image_path = :image_path,
                              tanggal_terbit = :tanggal_terbit,
                              genre = :genre
                          WHERE album_id = :album_id";
                $this->db->query($query);
                $this->db->bind(':judul', $judul);
                $this->db->bind(':image_path', $image_path);
                $this->db->bind(':tanggal_terbit', $tanggal_terbit);
                $this->db->bind(':genre', $genre);
                $this->db->bind(':album_id', $id);
                $result = $this->db->single_result();
            } catch ( error $e ) {
                echo $e;
                $result = NULL;
            }
            return $result;
        }
        
        public function deleteAlbum($id) {
            $result;
            try {
                $query = "DELETE FROM album 
                          WHERE album_id = :album_id";
                $this->db->query($query);
                $this->db->bind(':album_id');
                $result = $this->db->single_result();
            } catch ( error $e ) {
                echo 'ERROR!';
                $result = NULL;
            }
            return $result;
        }
    }

?>