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