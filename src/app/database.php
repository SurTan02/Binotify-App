<?php
    class Database {
        private $db_connection;
        private $query;

        public function __construct() {
            $host = "db";
            $dbuser = "postgres";
            $dbpass = "postgres";
            $port = "5432";
            $dbname = "database";

            $this->db_connection = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);
        }

        public function query($query) {
            $this->query = $this->db_connection->prepare($query);
        }

        public function execute() {
            $res = $this->query->execute();
            return $res;
        }

        public function multi_result() {
            $this->execute();
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single_result() {
            $this->execute();
            return $this->query->fetch(PDO::FETCH_ASSOC);
        }
                
    }
?>