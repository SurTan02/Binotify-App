<?php

require_once "./database.php";

class UserDB{
  private $table;
  private $db;

  public function __construct(){
    $this->table = "\"user\" ";
    $this->db = new Database();
  }

  // insert user
  public function insertUser($data){
    try{
      $this->db->query("INSERT INTO $this->table (username, email, password) VALUES (:username, :email, :password)");
      $this->db->bind(':username', $data['username']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      $id = $this->db->lastInsertId();
      return true;
    }
    catch(PDOException $e){
      echo "Error insert user";
    }
  }
  
}
  // create class userDB
  $userDB = new UserDB();
  $userDB->insertUser([
    'username' => 'fikrikhoironn',
    'email' => 'fikrikf470@gmail.com',
    'password' => 'devill027'
  ]);

?>