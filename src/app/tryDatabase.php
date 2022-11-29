<?php

require_once "./database.php";
require_once "./model/Subscription.php";

// test get all user
$user = new Subscription();
$result = $user->getSubscriptionById(1);
print_r($result);

?>
