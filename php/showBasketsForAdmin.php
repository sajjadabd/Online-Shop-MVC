<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$basket_results = array();
$returnBaskets = array();

$start = myFirstSanitize($_POST['start']);

$checkUser = "SELECT * FROM baskets ORDER BY basket_id DESC LIMIT 10 OFFSET $start";
$res = mysqli_query($con, $checkUser);

if($res == false){
	// Error On Database
} else {
	
	$count_baskets = mysqli_num_rows($res);
	
	$basket_results = array();
	$insideEachBasket = array();
	$userInfoArray = array();
	if($count_baskets > 0){
		while( $row = mysqli_fetch_array($res) ) {
			$basket_results[] = $row;
			
			$basket_id = $row['basket_id'];
			$user_id = $row['user_id'];
			//$basket_results[$counter]['uniq_id']      = $row['uniq_id'];
			//$basket_results[$counter]['price']        = $row['price'];
			//$basket_results[$counter]['date']         = $row['date'];

			$selectItemsInBasket = 
			"SELECT orders.* FROM orders
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

			
			$userInfo = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
			$userInfoRes = mysqli_query($con, $userInfo);
			if($userInfoRes === false){

			} else {
				$countUser = mysqli_num_rows($userInfoRes);
				if($countUser > 0){
					while($info = mysqli_fetch_array($userInfoRes)){
						$userInfoArray[] = $info;
					}
				}
			}
			
			$returnBaskets[] = array(
				'basket'=>$basket_results,
				'inside_basket'=>$insideEachBasket,
				'userInfo'=>$userInfoArray
			);
			//$returnBaskets[] = array('basket'=>$row,'inside_basket'=>$insideEachBasket);
			
			//$insideEachBasket = array();
			
			$basket_results = array();
			$insideEachBasket = array();
			$userInfoArray = array();
		}
					
	}
}

echo json_encode($returnBaskets);

?>