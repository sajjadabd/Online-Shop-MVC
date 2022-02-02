<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

$users = array();


$username = myStringSanitize($_POST['username']);
$zipcode  = myStringSanitize($_POST['zipcode']);
$address  = myStringSanitize($_POST['address']);
$phone    = phoneSanitize($_POST['phone']);
$sms      = myFirstSanitize($_POST['sms']);
$province = myStringSanitize($_POST['province']);
$city     = myStringSanitize($_POST['city']);
$live_in_city = myStringSanitize($_POST['live_in_city']);
$live_in_rural = myStringSanitize($_POST['live_in_rural']);

if( $phone == false || $sms == false || 
	$username === false || $zipcode === false || $address === false
	|| $province === false || $city === false ){
	echo json_encode(array('sanitize'=>false));
	exit();
}

$checkProvince = "SELECT * FROM provinces WHERE province_name='$province'";
$res = mysqli_query($con , $checkProvince);

if($res === false){
	
} else {
	$count_province = mysqli_num_rows($res);
	if($count_province > 0){
		
	} else {
		echo json_encode(array('province'=>false));
		exit();
	}
}


$checkCity = "SELECT * FROM cities WHERE city_name='$city'";
$res = mysqli_query($con , $checkCity);

if($res === false){
	
} else {
	$count_city = mysqli_num_rows($res);
	if($count_city > 0){
		
	} else {
		echo json_encode(array('city'=>false));
		exit();
	}
}

// echo json_encode(array(
// 	'city'=>$live_in_city,
// 	'rural'=>$live_in_rural,
// ));
// exit();

$liveInCity = "bug";
if($live_in_city == "true"){
	$liveInCity = 1;
	// echo json_encode(array('city'=>true));
	// exit();
} else if($live_in_rural == "true"){
	$liveInCity = 0;
	// echo json_encode(array('rural'=>true));
	// exit();
}

//$liveInCity = strval($liveInCity);
//$liveInCity = (string)$liveInCity;

// echo json_encode(array(
// 	'username'=>$username,
// 	'zipcode'=>$zipcode,
// 	'address'=>$address,
// 	'province'=>$province,
// 	'city'=>$city,
// 	'live_in_city'=>$live_in_city,
// 	'live_in_rural'=>$live_in_rural,
// ));
// exit();


$checkUserExist = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con, $checkUserExist);

if($res == false) {
	$users['select_user_error'] = true;
} else {
	$count_user = mysqli_num_rows($res);
	if( $count_user > 0 ){

		while( $row = mysqli_fetch_array($res) ) {
			$user_id = $row['user_id'];
		}
		
		$updateUser = "UPDATE users SET 
		username='$username', 
		zipcode='$zipcode', 
		address='$address', 
		province='$province',
		city='$city',
		live_in_city='$liveInCity'
		WHERE phone='$phone' AND sms='$sms' AND user_id='$user_id'";

		$res = mysqli_query($con, $updateUser);

		if($res == false) {
			// Error On UPDATE users
			$users['update_error'] = true;
		} else {			
			$users['success'] = true;
		}
	} else {
		// No Body Found
	}
	
}

echo json_encode($users);

?>