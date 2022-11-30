<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/app/database.php';

class Subscription {
    public function __construct($creator_id, $subscriber_id, $status)
    {
        $this->creator_id = $creator_id;
        $this->subscriber_id = $subscriber_id;
        $this->status = $status;
    }
}

ignore_user_abort(true);
set_time_limit(0);

$client = new SoapClient('http://binotify-soap-service:8081/com/binotifysoap/SubscriptionService?wsdl');
$db = new Database();
$count = 0;

while (true) {
    $db_res;
    try {
        $query  = "SELECT * FROM subscription WHERE status = 'PENDING'";
        $db->query($query);
        $db_res = $db->multi_result();
    } catch (Exception $e) {
        echo 'ERROR: ' .$e->getMessage();
    }

    $params = array();

    $count++;

    if (count($db_res) == 0) {
        // sleep(10); 
        continue;
    }

    foreach ($db_res as $d) {
        $data = new Subscription($d['creator_id'], $d['subscriber_id'], $d['status']);
        array_push($params, $data);
    }

    $poll_res;
    try {
        $poll_res = $client->__soapCall("PollSubscriptionsStatus", array($params));
    } catch (Exception $e) {
        echo 'ERROR: ' .$e->getMessage();
    }

    foreach ($poll_res->Subscriptions as $d) {
        print_r($d);
        try {
        $query  = "UPDATE subscription SET status = :status WHERE creator_id = :creator_id AND subscriber_id = :subscriber_id";
        $db->query($query);
        $db->bind(':status', $d->status);
        $db->bind(':creator_id', $d->creator_id);
        $db->bind(':subscriber_id', $d->subscriber_id);
        $db->execute();
        } catch (Exception $e) {
            echo 'ERROR: ' .$e->getMessage();
        }
    }
}
?>