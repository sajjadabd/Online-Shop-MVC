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
    }
}


// product_id , multiply FROM orders
// product_id , title , category,  description , price , picture FROM products
$returnCartCommand = "SELECT products.* ,orders.multiply,orders.user_id  
					  FROM products , orders 
                      WHERE user_id='$user_id' 
                      AND activation='0' 
                      AND products.product_id=orders.product_id
                      LIMIT 10 OFFSET $start";


$res = mysqli_query($con, $returnCartCommand);

$returnOrders = array();


$productPictures = array();
$productData = array();
if($res == false) {
    // Error On Select orders
} else {
    $count_orders = mysqli_num_rows($res);
    if($count_orders > 0){
        while( $row = mysqli_fetch_array($res) ) {
            $productData[] = $row;
            $product_id = $row['product_id'];
    
            $selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
            $resPics = mysqli_query($con,$selectPictures);
    
            if($resPics === false){
    
            } else {
                while($pics = mysqli_fetch_array($resPics)){
                    $productPictures[] = $pics;
                }
            }
    
            $returnOrders[] = array('product'=>$productData,'pictures'=>$productPictures);
        
            $productPictures = array();
            $productData = array();
        }
    } else {
        echo json_encode(array('count'=>$count_orders,'start'=>(int)$start));
        exit();
    }
    
}

echo json_encode($returnOrders);

?>