<?php
require_once('connect.php');
require_once('functions.php');

$users = array();

$users['success'] = false;

if(!isset($_POST['phone'])){
	echo json_encode($users);
	exit();
}
if(!isset($_POST['sms'])){
	echo json_encode($users);
	exit();
}

$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);


if($phone == false || $sms == false){
	echo json_encode($users);
	exit();
}


$selectAllUsers = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con, $selectAllUsers);

$users['success'] = false;

if($res == false) {
    // Error On Select users
	$users['success'] = false;
} else {
	$count_users = mysqli_num_rows($res);
	if( $count_users > 0 ) {
		while( $row = mysqli_fetch_array($res) ) {
			$users[] = $row;
		}
		
		$users['success'] = true;
	} else {
		$users['success'] = false;
	}
    
}

echo json_encode($users);

?>