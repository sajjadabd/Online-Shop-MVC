<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('success' => false));
    exit();
}

$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);

if(empty($phone) || empty($sms)) {
    echo json_encode(array('success' => false));
    exit();
}

$returnUserData = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con, $returnUserData);

$userData = array();

if($res == false) {
    // Error On Select user
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $userData['username'] = $row['username'];
        $userData['zipcode'] = $row['zipcode'];
        $userData['address'] = $row['address'];
        $userData['province'] = $row['province'];
        $userData['city'] = $row['city'];
        $userData['live_in_city'] = $row['live_in_city'];

    }
	
	$result['success'] = true;
}

echo json_encode($userData);

?>