<?php
  require_once __DIR__ . '/../db/Database.php';
  class User {
    private $table = DB_TABLE_USERS;
  }

  public function __construct() {
    $this->table = DB_TABLE_USERS;
  }

?>