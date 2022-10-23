<?php
    class Database {
        private $db_connection;
        private $statement;

        public function __construct() {
            $host = "db";
            $dbuser = "postgres";
            $dbpass = "postgres";
            $port = "5432";
            $dbname = "database";
            
            $this->db_connection = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);
        }

        public function query($query) {
            $this->statement = $this->db_connection->prepare($query);
        }

        public function execute() {
            $res = $this->statement->execute();
            return $res;
        }

        public function bind($param, $value) {
            $this->statement->bindValue($param, $value);
        }

        public function multi_result() {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single_result() {
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }

        public function lastInsertId() {
            $this->execute();
            return $this->db_connection->lastInsertId();
        }

        public function rowCount() {
            $this->execute();
            return $this->statement->fetchColumn();
        }
                
        // public function admin(){
        //     $password = password_hash("sayaadmin", PASSWORD_DEFAULT);
        //     $this->query("UPDATE \"user\"  SET password = '$password' ");
        //     $this->execute();
        // }
        
    }
?>