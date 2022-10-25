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

  // get user by user_id
  public function getUserById($user_id){
    try{
      $this->db->query("SELECT * FROM $this->table WHERE user_id = :user_id");
      $this->db->bind(':user_id', $user_id);
      $result = $this->db->single_result();
      return $result;
    }
    catch(PDOException $e){
      echo "Error user id gaada";
    }
  }

  // get role by user_id
  public function getRoleById($user_id){
    try{
      $this->db->query("SELECT isadmin FROM $this->table WHERE user_id = :user_id");
      $this->db->bind(':user_id', $user_id);
      $result = $this->db->single_result();
      echo "aman";
      return $result['isadmin'];
    }
    catch(PDOException $e){
      
    }
  }
  
}
  // // create class userDB
  // $userDB = new UserDB();
  // // get user by id 1
  // // $user = $userDB->getUserById(51);
  // // echo $user['username'];
  // // get role by id 51
  // $role = $userDB->getRoleById(51);
  // echo $role;


?>