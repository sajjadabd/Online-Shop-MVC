<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

if( isset($_POST['phone']) && 
	isset($_POST['sms']) && 
	isset($_POST['changer'])  && 
	isset($_POST['product_id']) ){
	
} else {
	echo json_encode(array('success'=>false,'set'=>false));
	exit();
}


$product_id = myFirstSanitize($_POST['product_id']);
$changer    = myFirstSanitize($_POST['changer']);
$phone      = myFirstSanitize($_POST['phone']);
$sms        = myFirstSanitize($_POST['sms']);

if( $changer === false || $phone === false || $sms === false ){
	echo json_encode(array('sanitize'=>false));
	exit();
}

if( $changer == 1 || $changer == -1 ){
	
}else {
	echo json_encode(array('changerRange'=>false));
	exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkUser);

if($res == false){
	
} else {
	$count_users = mysqli_num_rows($res);
	if($count_users > 0){
		while( $row = mysqli_fetch_array($res) ) {
			$user_id = $row['user_id'];
			//echo json_encode(array('user'=>$user_id));
			//exit();
		}
	}

}

$selectAllOrders = "SELECT orders.*, products.price , products.stock FROM orders 
					LEFT JOIN products ON orders.product_id=products.product_id
					WHERE orders.user_id='$user_id' AND orders.product_id='$product_id' AND orders.activation='0' LIMIT 1";

$res = mysqli_query($con, $selectAllOrders);

if($res === false){
	echo json_encode(array('orders'=>false));
	exit();
} else {
	$count_orders = mysqli_num_rows($res);
	//echo json_encode(array('orders'=>$count_orders));
	//exit();
	if($count_orders>0){
		while( $row = mysqli_fetch_array($res) ) {
			$multiply = $row['multiply'];
			$price    = $row['price'];
			$stock = $row['stock'];
		}
	} else {
		echo json_encode(array('count_orders'=>$count_orders));
		exit();
	}
}

$price = (int)$price;

$multiply += $changer;
if($multiply < 1){
	$multiply = 1;
}
if( $multiply > $stock ){
	echo json_encode(array('stock_error'=>true));
	exit();
}

$price = $multiply*$price;

$updateOrder = "UPDATE orders SET multiply='$multiply' WHERE product_id='$product_id' AND 
                user_id='$user_id' AND activation='0'";
$res = mysqli_query($con , $updateOrder);



$product_data = array();

		
if($res == false) {
    // Error On Select users
	echo json_encode(array('select_user_error'=>true));
	exit();
} else {
	$selectAllOrders = "SELECT * FROM orders WHERE user_id='$user_id' AND product_id='$product_id' AND activation='0' LIMIT 1";
	$res = mysqli_query($con, $selectAllOrders);
	
	if($res === false){
		echo json_encode(array('orders'=>false));
		exit();
	} else {
		$count_orders = mysqli_num_rows($res);
		//echo json_encode(array('orders'=>$count_orders));
		//exit();
		if($count_orders>0){
			while( $row = mysqli_fetch_array($res) ) {
				$product_data['multiply'] = $row['multiply'];
			}
			
			echo json_encode(array('multiply'=>$product_data['multiply'],'price'=>$price));
		} else {
			echo json_encode(array('success'=>false));
		}
	}
}



?>