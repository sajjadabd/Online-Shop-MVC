<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['basket_id'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$basket_id = $_POST['basket_id'];

if($basket_id === false){
    echo json_encode(array('sanitize'=>false));
    exit();
}

$checkBasketIsProcessed = "SELECT * FROM baskets WHERE basket_id='$basket_id' AND process='1'";
$res = mysqli_query($con , $checkBasketIsProcessed);

$count_baskets = mysqli_num_rows($res);

if($count_baskets > 0){
    echo json_encode(array('success'=>true,'before'=>true));
    exit();
} else {
    
}


$updateBasketProcess = "UPDATE baskets SET process='1' WHERE basket_id='$basket_id' AND process='0'";
$res = mysqli_query($con , $updateBasketProcess);

if($res === false){
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    
}
//send_sms15276

$getUserData = "SELECT * FROM baskets WHERE basket_id='$basket_id' LIMIT 1";
$getUserDataRes = mysqli_query($con , $getUserData);

if($getUserDataRes === false){
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    $count_baskets = mysqli_num_rows($getUserDataRes);
    if($count_baskets > 0){
        
        while($row = mysqli_fetch_array($getUserDataRes) ) {
            $user_id = $row['user_id'];
            $phone = $row['phone'];
            $basket_price = $row['basket_price'];
            $basket_post_price = $row['basket_post_price'];
        }
        
        $total_price = (int)$basket_price + (int)$basket_post_price ;
        
        //send sms to user
        send_sms15324($phone,$total_price);
        
        echo json_encode(array('success'=>true));
        exit();
        
    } else {
        
    }
}



?>