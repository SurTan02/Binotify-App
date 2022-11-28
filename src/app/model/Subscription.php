<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php';
  
  // create Subscription class
  class Subscription {
    private $table;
    private $db;
  

  public function __construct(){
    $this->table = "subscription";
    $this->db = new Database();
  }

  // get subscription by subscriber_id
  public function getSubscriptionById($subscriber_id){
    try{
      $query = "SELECT * FROM subscription WHERE subscriber_id = :subscriber_id";
      $this->db->query($query);
      $this->db->bind(':subscriber_id', $subscriber_id);
      $result = $this->db->multi_result();
    } catch (error $e) {
      echo 'ERROR!';
      $result = NULL;
    }
    return $result;
  }
}
?>