<?php
require_once('connect.php');
require_once('functions.php');

$returnProducts = array();

$start = myFirstSanitize($_POST['start']);

if(isset($_POST['phone']) && isset($_POST['sms'])) {
    $phone = myFirstSanitize($_POST['phone']);
	$sms   = myFirstSanitize($_POST['sms']);
	

    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);
    
    if($res == false) {
        // Error On Select products
    } else {
		$count_users = mysqli_num_rows($res);
		
		if( $count_users > 0 ) {
			while( $row = mysqli_fetch_array($res) ) {
				$user_id = $row['user_id'];
			}
		
			# SELECT ... FROM t1 JOIN (t2 JOIN t3 ON ...) ON ...
			$selectAllProducts = "SELECT products.*, myOrder.user_id, myOrder.multiply , mySave.save_id
								  FROM products
								  LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') AS myOrder 
								  ON myOrder.product_id=products.product_id
								  LEFT JOIN (SELECT * FROM saved WHERE user_id='$user_id') AS mySave ON mySave.product_id=products.product_id
								  ORDER BY product_id LIMIT 10 OFFSET $start";

			
		} else {
			$selectAllProducts = "SELECT * FROM products LIMIT 10 OFFSET $start";

			/*
			$res = mysqli_query($con , $selectAllProducts);

			if($res == false){
				// Error On Select products
			} else {
				while( $row = mysqli_fetch_array($res) )
				{
					$returnProducts[] = $row;
				}
			}
			*/
		}
    }
    
} else {

	$selectAllProducts = "SELECT * FROM products LIMIT 10 OFFSET $start";
	
	/*
    $res = mysqli_query($con , $selectAllProducts);

    if($res == false){
        // Error On Select products
    } else {
        while( $row = mysqli_fetch_array($res) )
        {
            $returnProducts[] = $row;
        }
	}
	*/
}

$res = mysqli_query($con, $selectAllProducts);
			
$eachProduct = array();
$productPictures = array();
if($res == false) {
	// Error On Select products
	//echo json_encode(array('db_error'=>true));
	//exit();
} else {
	while( $row = mysqli_fetch_array($res) ) {
		$eachProduct[] = $row;
		$product_id = $row['product_id'];
		//echo json_encode(array('product_id'=>$product_id));
		//exit();

		$selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
		$pictureRes = mysqli_query($con , $selectPictures);


		if($res === false){

		} else {
			while($pic = mysqli_fetch_array($pictureRes)){
				$productPictures[] = $pic;
				//echo json_encode(array('pics'=>$productPictures));
				//exit();
			}
		}

		$returnProducts[] = array('product'=>$eachProduct,'pictures'=>$productPictures);
		
		//echo json_encode($returnBaskets);
		//exit();
		$productPictures = array();
		$eachProduct = array();
	}
}



echo json_encode($returnProducts);

?>