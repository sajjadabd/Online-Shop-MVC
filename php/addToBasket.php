<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

$addToBasketResult = array();

$addToBasketResult['start'] = true;

if(isset($_POST['phone']) && isset($_POST['sms']) 
	&& isset($_POST['productId']) && isset($_POST['counter'])){

}
else{
    echo json_encode(array('set'=>false));
    exit();
}

$phone     = myFirstSanitize($_POST['phone']);
$sms       = myFirstSanitize($_POST['sms']);
$productId = myFirstSanitize($_POST['productId']);
$counter   = myFirstSanitize($_POST['counter']);


if($phone == false || $sms == false || $productId == false || $counter == false){
    echo json_encode(array('sanitize'=>false));
    exit();
}

if(empty($phone) || empty($sms) || empty($productId) || empty($counter)){
    echo json_encode(array('empty'=>true));
    exit();
}

if($counter >= 1){

} else {
	echo json_encode(array('counter'=>false));
    exit();
}

$addToBasketResult['productId'] = $productId; 

$checkStock = "SELECT * FROM products WHERE product_id='$productId' LIMIT 1";
$res = mysqli_query($con , $checkStock);

if($res === false){
	echo json_encode(array('db_error1'=>true));
    exit();
} else {
	$count = mysqli_num_rows($res);
	if($count >0){
		while($row = mysqli_fetch_array($res)){
			$stock = $row['stock'];
			$title = $row['title'];
			$brand = $row['brand'];
			$price = $row['price'];
			$description = $row['description'];
		}
	} else {
		$stock = 0;
	}
}

$checkUserCommand = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$checkUserResult = mysqli_query($con, $checkUserCommand);


if($checkUserResult == false){
	echo json_encode(array('db_error2'=>true));
    exit();
} else {
    $addToBasketResult['checkUser'] = true;
	
	$count_users = mysqli_num_rows($checkUserResult);
	if($count_users > 0){
		while( $row = mysqli_fetch_array($checkUserResult) ) {
			$user_id = $row['user_id'];
		}
	} else {
		echo json_encode(array('count_user'=>$count_users));
		exit();
	}
}


$multiplyChangeCommand = "SELECT * FROM orders WHERE user_id='$user_id' AND product_id='$productId' AND activation='0' LIMIT 1";
$multiplyChangeResult = mysqli_query($con , $multiplyChangeCommand);

if( $multiplyChangeResult == false ){
    $addToBasketResult['multiplyCheckResult_Error'] = true;
} else {
	
    $order_count = mysqli_num_rows($multiplyChangeResult);

    if($order_count > 0) { # Prodyct Already Exist And Just The multiply VALUE Should increment
        while( $row = mysqli_fetch_array($multiplyChangeResult) ) {
            $multiply = $row['multiply'];
            $multiply += $counter;
        }
		$addToBasketResult['multiply'] = $multiply;
		
		if( $multiply > $stock ) {
			echo json_encode(array('stock_error'=>true));
			exit();
		}
		
        $updateProductInOrders = "UPDATE orders SET multiply='$multiply' WHERE user_id='$user_id' AND product_id='$productId' AND activation='0'";
        $updateProductResults = mysqli_query($con , $updateProductInOrders);

        if($updateProductResults == false){
			
        } else {
			
        }


    } else { # New Product Should INSERT INTO orders
		
		$multiply = 0;
		$multiply += $counter;
		$addToBasketResult['multiply'] = $multiply;
		
		if( $multiply > $stock ) {
			echo json_encode(array('stock_error'=>true));
			exit();
		}
		
        $insertIntoOrders = "INSERT INTO orders (user_id,product_id,title,brand,price,description,multiply,activation) VALUES
        ('$user_id','$productId','$title','$brand','$price','$description','$multiply','0')";
       $res = mysqli_query($con, $insertIntoOrders);
       
       if($res == false){
			echo json_encode(array('db_error'=>true));
			exit();
       } else {
			
       }
    }
}

echo json_encode($addToBasketResult);

?>