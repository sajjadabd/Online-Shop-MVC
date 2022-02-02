<?php
require_once('connect.php');
require_once('functions.php');
require_once('jdatetime.php');

if( isset($_POST['phone']) && isset($_POST['sms']) ){

    $phone = myFirstSanitize($_POST['phone']);
    $sms   = myFirstSanitize($_POST['sms']);
    
    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
    $res = mysqli_query($con , $checkUser);
    
    if( $res == false ){
        // Error On Selecting User
    } else {

        while( $row = mysqli_fetch_array($res) ) {
            $user_id = $row['user_id'];
            $number_of_shopping = $row['number_of_shopping'];
        }

        $number_of_shopping = (int)$number_of_shopping;
        $number_of_shopping += 1;
        
        $increase_number_of_shopping = "UPDATE users SET number_of_shopping='$number_of_shopping' WHERE user_id='$user_id'";
        $increaseShoppingNumber = mysqli_query($con , $increase_number_of_shopping);
		
		$calculatePrice = "SELECT orders.*, products.price, products.stock FROM orders 
		LEFT JOIN products ON orders.product_id=products.product_id
        WHERE orders.user_id='$user_id' AND orders.activation='0'";
        
		$res = mysqli_query($con , $calculatePrice);
		
		$priceTemp = 0;
		$mul = 0;
		$price = 0;
		
		if($res === false){
		
		} else {
			while( $row = mysqli_fetch_array($res) ) {
				$priceTemp = $row['price'];
                $mul = $row['multiply'];
                $product_id = $row['product_id'];
                $stock = $row['stock'];

                $finalStock = $stock - $mul;

                $decreaseStock = "UPDATE products SET stock='$finalStock' WHERE product_id='$product_id'";
                $decreaseStockResult = mysqli_query($con , $decreaseStock);

				$price += ($priceTemp * $mul);
			}
		}
		
        //$uniq_id = uniqid();
        
        
        date_default_timezone_set('Asia/Tehran');
        
        $dateNow = jDateTime::date('l j F Y H:i');
        
        $process = 0;
        $payment_check = 0;
        $customer_regret = 0;

		$insertBasket = "INSERT INTO baskets (user_id, phone, price, process ,payment_check, customer_regret, date) 
        VALUES ('$user_id', '$phone', '$price', '$process' , '$payment_check' , '$customer_regret' ,  '$dateNow')";
        
        $res = mysqli_query($con, $insertBasket);
		
		$basket_id = mysqli_insert_id($con);
		

        $updateAllOrders = "UPDATE orders SET activation='1', basket_id='$basket_id' WHERE user_id='$user_id' AND activation='0'";
        $res = mysqli_query($con, $updateAllOrders);
		
		
		$UpdateOrders = array();

        if( $res == false ){
            $UpdateOrders['success'] = false;
        } else {
            $UpdateOrders['success']   = true;
            $UpdateOrders['basket_id'] = $basket_id;
            $UpdateOrders['user_id']   = $user_id;
			
        }
		

    }
} else {
    echo json_encode(array('success'=>false));
    exit();
}

echo json_encode($UpdateOrders);

?>