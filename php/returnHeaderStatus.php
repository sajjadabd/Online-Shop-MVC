<?php
require_once('connect.php');
require_once('functions.php');

$configStatusCounter = 0;
$numberOfOrdersInBasket = 0;

$status = array(
	'basketNumber' => $numberOfOrdersInBasket,
	'configNumber' => $configStatusCounter
);

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('success'=>false));
    exit();
}

$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);


if(empty($phone) || empty($sms)){
    echo json_encode(array('success'=>false));
    exit();
}


$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con, $checkUser);

if($res == false) {
    // Error On Select users
} else {
    $count_users = mysqli_num_rows($res);
    if($count_users > 0){
        while( $row = mysqli_fetch_array($res) ) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $zipcode = $row['zipcode'];
            $address = $row['address'];
        }
                
        if(strcmp(trim($username),'') == 0)
            $configStatusCounter++;
        if(strcmp(trim($zipcode),'') == 0)
            $configStatusCounter++;
        if(strcmp(trim($address),'') == 0)
            $configStatusCounter++;


        $selectOrders = "SELECT * FROM orders WHERE user_id='$user_id' AND activation='0'";
        $res = mysqli_query($con, $selectOrders);

        if($res == false) {
            // Error On Select users
        } else {
            //$numberOfOrdersInBasket = mysqli_num_rows($res);
            while( $row = mysqli_fetch_array($res) ) {
                $numberOfOrdersInBasket += $row['multiply'];
            }
        }

    }  
}


$status = array(
	'basketNumber' => $numberOfOrdersInBasket,
	'configNumber' => $configStatusCounter
);

echo json_encode($status);

?>