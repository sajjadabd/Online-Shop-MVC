<?php
require_once('connect.php');
require_once('functions.php');

//echo json_encode($_POST);
//exit();

if(isset($_POST['phone']) && isset($_POST['sms'])){
	
} else {
	echo json_encode(array('user'=>false));
	exit();
}

if(isset($_POST['complainTopic']) && isset($_POST['complainText'])){
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}


$phone = phoneSanitize($_POST['phone']);
$sms = myFirstSanitize($_POST['sms']);

$complainTitle = myStringSanitize($_POST['complainTopic']);
$complainText = myStringSanitize($_POST['complainText']);

if($phone === false || $sms === false 
	|| $complainTitle === false || $complainText === false){
	echo json_encode(array('sanitize'=>false));
	exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkUser);

if($res === false){
	echo json_encode(array('db_error1'=>true));
	exit();
} else {
	$count = mysqli_num_rows($res);
	if($count >0){
		
		while($row = mysqli_fetch_array($res)){
			$user_id = $row['user_id'];
		}
		
		$insertComplain = "INSERT INTO complains (user_id,phone,complain_title,complain_text)
						VALUES ('$user_id','$phone','$complainTitle','$complainText')";
						
		$insert = mysqli_query($con , $insertComplain);
		
		if( $insert === false ) {
			echo json_encode(array('db_error2'=>true));
			exit();
		} else {
			echo json_encode(array('success'=>true));
			exit();
		}

	} else {
		echo json_encode(array('count'=>$count));
		exit();
	}
}


?>