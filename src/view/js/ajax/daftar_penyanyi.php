<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Subscription.php';


class SubscriptionForSend {
  public function __construct($creator_id, $subscriber_id)
  {
      $this->creator_id = $creator_id;
      $this->subscriber_id = $subscriber_id;
  }
}

// class SoapHeader {
//   public function __construct()
//   {
//     $this->x-api-key = 'f93b06b72ce07bdfea7cc0fe9105f599';
//   }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  // $user_id = 1;
  if (isset($_POST["creator_id"])) {
    $creator_id = $_POST["creator_id"];
    // $creator_id = 4;

    
    $s = new Subscription(); 
    $result = $s->addSubscription($user_id, $creator_id);

    $client = new SoapClient('http://binotify-soap-service:8081/com/binotifysoap/SubscriptionService?wsdl', array("stream_context" => stream_context_create(array("http" => array(
      'header' => 'x-api-key: f922a587fa3e0eec5de229bcfc34bb52')))));
    $params = array("creator_id" => $creator_id, "subscriber_id" => $user_id);

    // $data = new SubscriptionForSend(4, 1);
    // array_push($params, $data);

    try {
        $client->__soapCall("addSubscription", array($params) );
    } catch (Exception $e) {
        echo 'ERROR: ' .$e->getMessage();
    }

  }
    
}

  
?>
