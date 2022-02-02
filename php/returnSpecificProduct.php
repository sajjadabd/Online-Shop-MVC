<?php
require_once('connect.php');
require_once('functions.php');

$phone = 'Nothing';
$sms = 'Nothing';

if(isset($_POST['phone']) && isset($_POST['sms'])) {
    $phone = phoneSanitize($_POST['phone']);
    $sms = myFirstSanitize($_POST['sms']);
}

$product_id = myFirstSanitize($_POST['product_id']);

$selectUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con , $selectUser);

if($res === false){
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    $count_user = mysqli_num_rows($res);

    if($count_user > 0){
        while($row = mysqli_fetch_array($res)) {
            $user_id = $row['user_id'];
        }

        $selectSpecificProduct = "SELECT products.*, myOrder.user_id, myOrder.multiply , mySave.save_id
                            FROM products
                            LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.product_id='$product_id' AND orders.activation='0') AS myOrder 
                            ON myOrder.product_id=products.product_id
                            LEFT JOIN (SELECT * FROM saved WHERE saved.user_id='$user_id' AND saved.product_id='$product_id') AS mySave ON mySave.product_id=products.product_id
                            WHERE products.product_id='$product_id'
                            LIMIT 1";


    } else {
        $selectSpecificProduct = "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1";

    }

    $returnProducts = array();

    $resPics = mysqli_query($con, $selectSpecificProduct);
			
    $eachProduct = array();
    $productPictures = array();
    if($res == false) {
        // Error On Select products
        //echo json_encode(array('db_error'=>true));
        //exit();
    } else {
        while( $row = mysqli_fetch_array($resPics) ) {
            $eachProduct[] = $row;
            $product_id = $row['product_id'];
            //echo json_encode(array('product_id'=>$product_id));
            //exit();

            $selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
            $pictureRes = mysqli_query($con , $selectPictures);


            if($pictureRes === false){

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
}

echo json_encode($returnProducts);

?>