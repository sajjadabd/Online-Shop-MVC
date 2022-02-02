<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

if(isset($_POST['phone']) && isset($_POST['sms']) 
	&& isset($_POST['changer'])  && isset($_POST['order_id'])){
	
} else {
	echo json_encode(array('success'=>false));
	exit();
}


$order_id= myFirstSanitize($_POST['order_id']);
$changer = myFirstSanitize($_POST['changer']);
$phone   = myFirstSanitize($_POST['phone']);
$sms     = myFirstSanitize($_POST['sms']);

if($changer === false || $phone === false || $sms === false ){
	echo json_encode(array('success'=>false));
	exit();
}

if( $changer === 1 || $changer === -1 ){
	
} else {
	echo json_encode(array('success'=>false));
	exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkUser);

if($res == false){
	
} else {
	$count_users = mysqli_num_rows($res);
	if($count_users > 0){
		while( $row = mysqli_fetch_array($res) )
		{
			$user_id = $row['user_id'];
		}
	}

}

$selectAllUsers = "SELECT * FROM orders WHERE user_id='$user_id' AND order_id='$order_id' AND activation='0'";
$res = mysqli_query($con, $selectAllUsers);

if($res === false){
	
} else {
	$count_orders = mysqli_num_rows($res);
	if($count_orders>0){
		while( $row = mysqli_fetch_array($res) ) {
			$multiply = $row['multiply'];
		}
	}
}

$multiply += $changer;

$updateOrder = "UPDATE orders SET multiply='$multiply' WHERE order_id='$order_id' AND 
                user_id='$user_id' AND activation='0'";
$res = mysqli_query($con , $updateOrder);
				

if($res == false) {
    // Error On Select users
} else {

}

echo json_encode(array('success'=>true));

?>