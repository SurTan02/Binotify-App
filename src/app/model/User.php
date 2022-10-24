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
      // validate the data is not empty
      if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
        return false;
      }

      // Validate that username is unique and email is an email.
      if (!$this->isValidUsername($data['username']) || !$this->isValidEmail($data['email'])) {
        return false;
      }

      // hash the password
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

      // insert into database

      try{
        // TODO: masalah dia kalau pakai prepare gabisa
        $this->db->query("INSERT INTO $this->table (username, email, password) VALUES (:username, :email, :password)");
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        // $this->db->bind(':isAdmin', false);
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


    // get role by user_id
    public function getRoleById($user_id){
      try{
        $this->query = "SELECT isAdmin FROM $this->table WHERE user_id = :user_id";
        $this->db->query($this->query);
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single_result();
        return $result['isAdmin'];
      }
      catch(PDOException $e){
        echo "Error role gaada";
      }
    }

    // validate that username is unique
    public function isValidUsername($username){
      try{
        // check using regex
        if(preg_match('/^[a-zA-Z0-9]{5,}$/', $username)){
          // check if username is already taken
          $this->query = "SELECT * FROM $this->table WHERE username = :username";
          $this->db->query($this->query);
          $this->db->bind(':username', $username);
          $result = $this->db->single_result();
          if($result){
            echo "taken";
          }
          else{
            echo "available";
          }
        }
        else{
          echo "invalid";
        }
      }
      catch(PDOException $e){
        echo "Error username gaada";
      }
    }

    public function isValidEmail($email){
      try{
        // check using regex
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          // check if email is already taken
          $this->query = "SELECT * FROM $this->table WHERE email = :email";
          $this->db->query($this->query);
          $this->db->bind(':email', $email);
          $result = $this->db->single_result();
          if($result){
            echo "taken";
          }
          else{
            echo "available";
          }
        }
        else{
          echo "invalid";
        }
      }
      catch(PDOException $e){
        echo "Error email gaada";
      }
    }

    // check is login valid
    public function isLoginValid($data) {
      // Validate that the data is not empty.
      if (!isset($data['username']) || !isset($data['password'])) {
        return false;
      }
  
      // get user data from DB
      $userToLogin = $this->getUserByUsername($data['username']);
      if (!$userToLogin) {
        return false;
      }
      else {
        //check if hashedPW === hashed password in the database
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