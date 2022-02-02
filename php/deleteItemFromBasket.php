<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms']) && isset($_POST['deleteItemId'])){

} else {
	echo json_encode(array('success' => false));
	exit();
}

$phone      = myFirstSanitize($_POST['phone']);
$sms        = myFirstSanitize($_POST['sms']);
$product_id = myFirstSanitize($_POST['deleteItemId']);

if($phone == false || $sms == false || $product_id == false){
	echo json_encode(array('success' => false));
	exit();
} else {
	
}

if(empty($phone) || empty($sms) || empty($product_id)){
	echo json_encode(array('success' => false));
	exit();
} else {

}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con , $checkUser);


$user_id = '';
if($res == false) {
    // Error On Select User
	$result['select_user_error'] = true;
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $user_id = $row['user_id'];
    }
	
	$deleteFromOrders = "DELETE FROM orders WHERE product_id='$product_id' AND 
	user_id='$user_id' AND activation='0'";
	$res = mysqli_query($con, $deleteFromOrders);

	if($res == false) {
		// Error On delete orders
		$result['success'] = false;
	} else {
		$result['success'] = true;
	}
}

echo json_encode($result);

?>