<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/model/Subscription.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php';

class SubscriptionForSend {
  public function __construct($creator_id, $subscriber_id)
  {
      $this->creator_id = $creator_id;
      $this->subscriber_id = $subscriber_id;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  // $user_id = 1;
  if (isset($_POST["creator_id"])) {
    $creator_id = $_POST["creator_id"];
    // $creator_id = 4;

    
    $s = new Subscription(); 

    $api = 'x-api-key: '. BINOTIFY_APP_SOAP_API_KEY;

    $client = new SoapClient('http://binotify-soap-service:8081/com/binotifysoap/SubscriptionService?wsdl', array("stream_context" => stream_context_create(array("http" => array(
      'header' => $api)))));
    $params = array("creator_id" => $creator_id, "subscriber_id" => $user_id);

    try {
        $client->__soapCall("AddSubscription", array($params) );
        $result = $s->addSubscription($user_id, $creator_id);
    } catch (Exception $e) {
        echo 'ERROR: ' .$e->getMessage();
    }

  }
    
}

  
?>
