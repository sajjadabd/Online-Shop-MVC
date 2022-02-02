<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
	echo json_encode(array('success'=>false));
	exit();
}

$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);
$start = myFirstSanitize($_POST['start']);

if(empty($phone) || empty($sms)){
	echo json_encode(array('success'=>false,'empty'=>true));
	exit();
}

if($phone === false || $sms === false){
	echo json_encode(array('success'=>false,'sanitize'=>false));
	exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con, $checkUser);

if($res == false){
	// Error On Database
} else {
	
	$count_users = mysqli_num_rows($res);
	
	if($count_users > 0) {

		while( $row = mysqli_fetch_array($res) ) {
			$user_id = $row['user_id'];
		}
		

		$selectAllBaskets = "SELECT baskets.*, orders.* FROM baskets
							LEFT JOIN orders ON baskets.basket_id=orders.basket_id 
							WHERE orders.user_id='$user_id' 
							GROUP BY baskets.basket_id 
							ORDER BY baskets.basket_id DESC  
							LIMIT 10 OFFSET $start";


		$res = mysqli_query($con, $selectAllBaskets);


		$returnBaskets = array();

		$eachBasket = array();
		$insideEachBasket = array();
		if($res == false) {
			// Error On Select orders
		} else	{
			while( $row = mysqli_fetch_array($res) ) {
				$eachBasket[] = $row;
				
				$basket_id = $row['basket_id'];
				
				$selectItemsInBasket = "SELECT orders.* FROM orders
										WHERE orders.user_id='$user_id' 
										AND orders.basket_id='$basket_id' 
										AND orders.activation='1'";
				
				$grabItems = mysqli_query($con , $selectItemsInBasket);
				
				
				$count_inside_baskets = mysqli_num_rows($grabItems);
				if($count_inside_baskets > 0){
					while( $inside_each_basket_array = mysqli_fetch_array($grabItems) )	{
						$insideEachBasket[] = $inside_each_basket_array;
					}
				}
				
				$returnBaskets[] = array('basket'=>$eachBasket,'inside_basket'=>$insideEachBasket);
				
				$eachBasket = array();
				$insideEachBasket = array();
			}
			$result['success'] = true;
		}
					
	}
}

echo json_encode($returnBaskets);

?>