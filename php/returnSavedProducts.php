<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('success'=>false,'set'=>false));
    exit();
}

$start   = myFirstSanitize($_POST['start']);

$phone = myFirstSanitize($_POST['phone']);
$sms   = myFirstSanitize($_POST['sms']);

if($phone === false || $sms === false){
    echo json_encode(array('success'=>false,'sanitize'=>false));
    exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkUser);

if($res === false){
    echo json_encode(array('success'=>false,'error'=>true));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        while($row = mysqli_fetch_array($res)) {
            $user_id = $row['user_id'];
        }
    }
}


$savedResults = "SELECT saved.* , products.* ,myOrder.user_id, myOrder.multiply FROM saved 
                LEFT JOIN products ON saved.product_id=products.product_id
                LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') AS myOrder 
                ON myOrder.product_id=products.product_id
                WHERE saved.user_id='$user_id' LIMIT 10 OFFSET $start";

$res = mysqli_query($con , $savedResults);

$returnSaved = array();

if($res === false){
    echo json_encode(array('success'=>false,'db_error'=>true));
    exit();
} else {
    $count = mysqli_num_rows($res);

    $productPictures = array();
    $productData = array();
    if($count > 0){

        //echo json_encode(array('count'=>$count));
        //exit();

        while($row = mysqli_fetch_array($res)) {
            $productData[] = $row;
            $product_id = $row['product_id'];
            
            $selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
            $resPics = mysqli_query($con , $selectPictures);

            if($resPics === false){

            } else {
                while( $pics = mysqli_fetch_array($resPics) ) {
                    $productPictures[] = $pics;
                }
            }

            $returnSaved[] = array('product'=>$productData,'pictures'=>$productPictures);

            $productPictures = array();
            $productData = array();
        }

        echo json_encode($returnSaved);
        exit();

    } else {
        echo json_encode(array('count'=>0,'start'=>(int)$start));
        exit();
    }
}


?>