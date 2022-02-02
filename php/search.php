<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();
if( isset($_POST['phone']) && isset($_POST['sms']) ){
	$phone = myFirstSanitize($_POST['phone']);
	$sms = myFirstSanitize($_POST['sms']);
} else {
	$phone = false;
	$sms = false;
}

$searchTerm = myStringSanitize($_POST['searchTerm']);
$searchTerm = arabicToPersian($searchTerm);

$start = myFirstSanitize($_POST['start']);


if(empty($searchTerm) && $phone === false && $sms === false ){
	
	$selectAllProducts = "SELECT * FROM products LIMIT 10 OFFSET $start";
	
} else if(!empty($searchTerm) && $phone === false && $sms === false ) {
	
    $selectAllProducts = "SELECT * FROM products 
						  WHERE title LIKE '%$searchTerm%' 
                          OR category LIKE '%$searchTerm%' 
						  OR brand LIKE '%$searchTerm%' 
						  LIMIT 10 OFFSET $start";

} else if(empty($searchTerm) && $phone !== false && $sms !== false ){

    
	$checkUser = "SELECT * FROM users 
				  WHERE phone='$phone' AND sms='$sms' 
				  LIMIT 1";

	$res = mysqli_query($con , $checkUser);
	
	if($res == false){
		
	} else {
		$count_users = mysqli_num_rows($res);

		if($count_users > 0){
			while( $row = mysqli_fetch_array($res) ) {
				$user_id = $row['user_id'];
			}

			$selectAllProducts = "SELECT products.*, myOrder.user_id, myOrder.multiply, mySave.save_id FROM products
						  LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') AS myOrder 
						  ON myOrder.product_id=products.product_id
						  LEFT JOIN (SELECT * FROM saved WHERE user_id='$user_id') AS mySave 
						  ON mySave.product_id=products.product_id LIMIT 10 OFFSET $start";
		}
	}
	
    

} else if(!empty($searchTerm) && $phone !== false && $sms !== false ){
	
	$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
	$res = mysqli_query($con , $checkUser);
	
	if($res == false){
		
	} else {
		$count_users = mysqli_num_rows($res);

		if($count_users > 0){
			while( $row = mysqli_fetch_array($res) )
			{
				$user_id = $row['user_id'];
			}
			
			$selectAllProducts = "SELECT products.*, myOrder.user_id, myOrder.multiply, mySave.save_id FROM products 
                                  LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') 
								  AS myOrder ON myOrder.product_id=products.product_id
								  LEFT JOIN (SELECT * FROM saved WHERE user_id='$user_id') AS mySave
								  ON mySave.product_id=products.product_id
                                  WHERE products.title LIKE '%$searchTerm%' 
                                  OR products.category LIKE '%$searchTerm%'	
								  OR products.brand LIKE '%$searchTerm%'								  
								  LIMIT 10 OFFSET $start";
								  								
		} else {
			$selectAllProducts = "SELECT * FROM products 
								  WHERE title LIKE '%$searchTerm%' 
                                  OR category LIKE '%$searchTerm%' 
								  OR brand LIKE '%$searchTerm%' 
								  LIMIT 10 OFFSET $start";
		}
		
	}
}


$res = mysqli_query($con, $selectAllProducts);

$returnProducts = array();


$productData = array();
$productPicture = array();
if($res == false)
{
	// Error On Select products
}
else
{
	while( $row = mysqli_fetch_array($res) ) {
		$productData[] = $row;
		$product_id = $row['product_id'];

		$selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
		$resPics = mysqli_query($con , $selectPictures);

		if($resPics === false){

		} else {
			while($pics = mysqli_fetch_array($resPics)){
				$productPicture[] = $pics;
			}
		}

		$returnProducts[] = array('product'=>$productData,'pictures'=>$productPicture);

		$productData = array();
		$productPicture = array();
	}
	$result['success'] = true;
}


echo json_encode($returnProducts);

?>