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

        public function updateAlbum($id, $judul, $penyanyi, $image_path, $tanggal_terbit, $genre) {
            $result;
            try {
                $query = "UPDATE album 
                          SET   ( judul,  penyanyi,  image_path,  tanggal_terbit,  genre) 
                          VALUE (:judul, :penyanyi, :image_path, :tanggal_terbit, :genre) 
                          WHERE album_id = :album_id";
                $this->db->query($query);
                $this->db->bind(':judul', $judul);
                $this->db->bind(':penyanyi', $penyanyi);
                $this->db->bind(':image_path', $image_path);
                $this->db->bind(':tanggal_terbit', $tanggal_terbit);
                $this->db->bind(':genre', $genre);
                $this->db->bind(':album_id');
                $result = $this->db->single_result();
            } catch ( error $e ) {
                echo 'ERROR!';
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

        public function addAlbum($data){
            
            // Must have component
            if (!isset($data['title']) || !isset($data['tanggal'])  ||
                !isset($data['penyanyi'])  ||
                !isset($data['genre']) || !isset($data['image_path'])) {
                return false;
            } 

            try {
                $this->db->query("INSERT INTO $this->table (judul, penyanyi, genre, tanggal_terbit, image_path, total_duration)
                                  VALUES (:judul, :penyanyi, :genre, :tanggal_terbit, :image_path, :duration)");
                $this->db->bind(':judul', $data['title']);
                $this->db->bind(':penyanyi', $data['penyanyi']);
                $this->db->bind(':genre', $data['genre']);
                $this->db->bind(':tanggal_terbit', $data['tanggal']);
                $this->db->bind(':image_path', $data['image_path']);
                $this->db->bind(':duration', 0);
                
                $this->db->execute();
                return true;
            } catch (error $e) {
                //throw $th;
                return false;
            }
        }
    }

?>