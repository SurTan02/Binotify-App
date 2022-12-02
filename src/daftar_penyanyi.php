<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/app/model/Subscription.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/cookies.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/helper/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/handlers/header_handler.php';

$head_html = file_get_contents('./view/html/templates/head.html');
// Replace any variables in the html files.
$head_html = str_replace('{title}', 'Brisic', $head_html);
$head_html = str_replace('{css1}', './view/css/components/header.css', $head_html);
$head_html = str_replace('{css2}', './view/css/daftar_penyanyi.css', $head_html);
$head_html = str_replace('{css3}', './view/css/components/card_penyanyi.css', $head_html);

$idUser = validateAuthCookie($_COOKIE);
$_SESSION['user_id'] = $idUser;
$user = new User();
$isAdmin = $user->getRoleById($idUser);
$username = $user->getUsernameById($idUser);

// if session["login"] is not set, use guest header
$isSetSession = isset($_SESSION["login"]);
$header_html = getHeader($isAdmin, $isSetSession, $username);
$daftar_penyanyi_html = file_get_contents('./view/html/daftar_penyanyi.html');

// get subscription data
$subscriptionDB = new Subscription();
$subscriptionData = $subscriptionDB->getSubscriptionById($idUser);

// get penyanyi
$api_url = 'http://binotify-rest-service-app:8080/user';
// Read JSON file
$json_data = file_get_contents($api_url);
// Decode JSON data into PHP array
$response_data = json_decode($json_data);
// All user data exists in 'data' object
$user_data = $response_data;


$user_list_html = "";
foreach ($user_data as $user) {
    $found = false;
    foreach ($subscriptionData as $subscriptionList){
        if ($user->user_id == $subscriptionList["creator_id"] && ($subscriptionList["status"] == "REJECTED" )){
            $found = true;
            $user_list_html = $user_list_html . 
                "<li class='list-singer'>
                    <div class='singer'>
                    <div class='singer-information1'>
                        <span 
                        class='singer-title'>$user->name</span>
                    </div>
                    <button class='rejected-button'>Rejected</button>
                    </div>
                </li>";
        }
        else if ($user->user_id == $subscriptionList["creator_id"] && ($subscriptionList["status"] == "PENDING" )){
            $found = true;
            $user_list_html = $user_list_html . 
                "<li class='list-singer'>
                    <div class='singer'>
                    <div class='singer-information1'>
                        
                        
                        <span class='singer-title'>$user->name</span>
                    </div>
                    <button class='pending-button'>Pending</button>
                    </div>
                </li>";
        }
        else if ($user->user_id == $subscriptionList["creator_id"] && $subscriptionList["status"] == "ACCEPTED"){
            $found = true;
            $user_list_html = $user_list_html . 
                "<li class='list-singer'>
                    <div class='singer'>
                    <div class='singer-information1'>   
                        <span class='singer-title'>$user->name</span>
                    </div>
                    <a href=daftar_lagu_premium.php?penyanyi=$user->user_id class='subscribed-button'>Check Out!</a>
                    </div>
                </li>";
        }
    }
    if (!$found){            
        $user_list_html = $user_list_html . 
            "<li class='list-singer'>
                <div class='singer'>
                <div class='singer-information1'>
                    <span class='singer-title'>$user->name</span>
                </div>
                <button class='subscribe-button' id='subscribe-button-$user->user_id' onClick =  'sendSubscriptionRequest($user->user_id)'>Subscribe
                </button> 
                </div>
            </li>";
    }
}
$daftar_penyanyi_html = str_replace('{user_list}', $user_list_html, $daftar_penyanyi_html);



echo $head_html;
echo $header_html;
echo $daftar_penyanyi_html;
echo '<script src="./view/js/daftar_penyanyi.js"></script>';
?>