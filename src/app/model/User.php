<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php';
  
  // create user class
  class User{
    private $db;
    private $table;
    private $query;

    // constructor
    public function __construct(){
      $this->db = new Database();
      
      $this->table = "\"user\" ";
    }

    // get single user by user_id
    public function getUserById($user_id){
      try{
        $this->query = "SELECT * FROM $this->table WHERE user_id = :user_id";
        $this->db->query($this->query);
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single_result();
        return $result;
      }
      catch(PDOException $e){
        echo "Error user id gaada";
      }
    }

    // get single user by username
    public function getUserByUsername($username){
      try{
        $this->query = "SELECT * FROM $this->table WHERE username = :username";
        $this->db->query($this->query);
        $this->db->bind(':username', $username);
        $result = $this->db->single_result();
        return $result;
      }
      catch(PDOException $e){
        echo "Error username gaada";
      }
    }

    // register user
    public function registerUser($data){
      if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
        return false;
      }
      if (!$this->isValidUsername($data['username']) || !$this->isValidEmail($data['email'])) {
        return false;
      }
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
      try{
        // TODO: masalah dia kalau pakai prepare gabisa
        $this->db->query("INSERT INTO $this->table (username, email, password) VALUES (:username, :email, :password)");
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        // $this->db->bind(':isadmin', false);
        $id = $this->db->lastInsertId();
        return $id;
        if(!empty($id)){
          return $id;
        }
        else{
          return false;
        }
      }
      catch(PDOException $e){
        echo "Error register";
      }


    }

    public function getRoleById($user_id){
      try{
        $this->query = "SELECT isadmin FROM $this->table WHERE user_id = :user_id";
        $this->db->query($this->query);
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single_result();
        return $result['isadmin'];
      }
      catch(PDOException $e){
        
      }
    }

    // get all user for pagination
    public function getAllUser($page){
      $result;
      try {
        $query = "SELECT COUNT(user_id) FROM $this->table";
        $this->db->query($query);
        $result['count'] = $this->db->single_result()['count'];

        $query = "SELECT * FROM $this->table ORDER BY user_id ASC OFFSET :page LIMIT 10";
        $this->db->query($query);
        $this->db->bind(':page', ($page - 1) * 10);
        $result['data'] = $this->db->multi_result();
      }
      catch(PDOException $e){
        echo "Error get all user";
        $result = NULL;
      }
      return $result;
    }
    public function isValidUsername($username){
      try{
        if(preg_match('/^[a-zA-Z0-9]{5,}$/', $username)){
          $this->query = "SELECT * FROM $this->table WHERE username = :username";
          $this->db->query($this->query);
          $this->db->bind(':username', $username);
          $result = $this->db->single_result();
          if($result){
            return false;
          }
          else{
            return true;
          }
        }
        else{
          return false;
        }
      }
      catch(PDOException $e){
        echo "Error username gaada";
      }
    }


    public function isValidEmail($email){
      try{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          $this->query = "SELECT * FROM $this->table WHERE email = :email";
          $this->db->query($this->query);
          $this->db->bind(':email', $email);
          $result = $this->db->single_result();
          if($result){
            return false;
          }
          else{
            return true;
          }
        }
        else{
          return false;
        }
      }
      catch(PDOException $e){
        echo "Error email gaada";
      }
    }

    public function isLoginValid($data) {
      if (!isset($data['username']) || !isset($data['password'])) {
        return false;
      }
      $userToLogin = $this->getUserByUsername($data['username']);
      if (!$userToLogin) {
        return false;
      }
      else {
        if (password_verify($data['password'], $userToLogin['password'])) {
          return $userToLogin['user_id'];
        }
        else {
          return false;
        }
      }
    }
  }
?>