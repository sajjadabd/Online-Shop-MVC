<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}


$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);

if($phone === false || $sms === false){
    echo json_encode(array('sanitize'=>false));
	exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con , $checkUser);

$user_id = '';
if($res == false) {
    // Error On Select User
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $user_id = $row['user_id'];
        $city = $row['city'];
        $province = $row['province'];
        $liveInCity = $row['live_in_city'];
    }
}

$returnCartCommand = "SELECT products.* ,orders.multiply,orders.user_id  
					  FROM products , orders 
                      WHERE user_id='$user_id' 
                      AND activation='0' 
                      AND products.product_id=orders.product_id";


$res = mysqli_query($con, $returnCartCommand);


$final_return_orders = array();
$returnOrders = array();

if($res === false){
    echo json_encode(array('success'=>false));
	exit();
} else {
    $count_orders = mysqli_num_rows($res);
    if($count_orders > 0){

        $basket_price = 0;
        while($row = mysqli_fetch_array($res)){

            $returnOrders[] = $row;


            $multiply = $row['multiply'];
            $price = $row['price'];

            $basket_price += $multiply * $price;
        }

        
        $fetchPostPrice = "SELECT * FROM cities WHERE city_name='$city' AND province_name='$province' LIMIT 1";
        $postPriceResult = mysqli_query($con, $fetchPostPrice);

        if($postPriceResult === false){

        } else {
            $count_city = mysqli_num_rows($postPriceResult);
            if($count_city > 0){
                while($row = mysqli_fetch_array($postPriceResult)){
                    $basket_post_price = $row['post_price'];
                    $rural_basket_post_price = $row['rural_post_price'];
                }
            }
        }
        
        $liveInCity = (int)$liveInCity;
        if($liveInCity === 1){
            
        } else {
            $basket_post_price = $rural_basket_post_price;
        }
        
        $total_price = (int)$basket_price + (int)$basket_post_price;

        $final_return_orders[] = array(
            'product'=>$returnOrders,
            'basket_price'=>(int)$basket_price,
            'basket_post_price'=>(int)$basket_post_price,
            'total_price'=>$total_price,
            );

        echo json_encode($final_return_orders);
        exit();
    } else {
        echo json_encode(array('count'=>$count_orders));
        exit();
    }
}

?>