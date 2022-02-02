<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_SESSION['admin_phone']) && isset($_SESSION['admin_sms'])){
	$phone = myFirstSanitize($_SESSION['admin_phone']);
	$sms = myFirstSanitize($_SESSION['admin_sms']);
} else if (isset($_COOKIE['admin_phone']) && isset($_COOKIE['admin_sms'])){
	$phone = myFirstSanitize($_COOKIE['admin_phone']);
	$sms = myFirstSanitize($_COOKIE['admin_sms']);
} else {
	echo json_encode(array('success'=>false,'set'=>false));
	exit();
}


if($phone === false || $sms === false){
	echo json_encode(array('success'=>false,'sanitize'=>false));
	exit();
}

$checkAdmin = "SELECT * FROM adminTable WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkAdmin);

if($res === false){
    echo json_encode(array('success'=>false,'db_error'=>true));
    exit();
} else {
    $count_admin = mysqli_num_rows($res);
    if($count_admin > 0){

    } else {
        echo json_encode(array('success'=>false,'admin'=>false));
        exit();
    }
}


?>