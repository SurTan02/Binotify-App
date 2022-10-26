<?php

require_once "./database.php";
require_once "./model/User.php";

class UserDB{
  private $table;
  private $db;
  private $query;

  public function __construct(){
    $this->table = "\"user\" ";
    $this->db = new Database();
    $this->query = "";
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

  // get no admin user for pagination
  public function getAllUser(
    $page = 1,
    $limit = 1000,
    $order = 'user_id',
    $sort = 'ASC'
  ){
    try{
      $offset = ($page - 1) * $limit;
      $this->query = "SELECT * FROM $this->table WHERE isadmin = false ORDER BY $order $sort LIMIT $limit OFFSET $offset";
      $this->db->query($this->query);
      // $this->db->bind(':limit', $limit);
      // $this->db->bind(':offset', $offset);

      $result = $this->db->multi_result();
      return $result;
    }
    catch(PDOException $e){
      echo "Error get all user";
    }
  }
  
}

// test get all user
$user = new User();
$result = $user->getAllUser(1);



?>