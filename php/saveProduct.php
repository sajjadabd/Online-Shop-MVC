<?php
require_once('connect.php');
require_once('functions.php');

//echo print_r($_POST);
//exit();

if(isset($_POST['product_id']) && isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$product_id = myFirstSanitize($_POST['product_id']);
$phone      = myFirstSanitize($_POST['phone']);
$sms        = myFirstSanitize($_POST['sms']);

if($product_id === false){
    echo json_encode(array('sanitize'=>false));
    exit();
}

$checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con , $checkUser);

if($res === false){
    echo json_encode(array('error'=>true,'user_select'=>false));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        while($row = mysqli_fetch_array($res)){
            $user_id = $row['user_id'];
        }

        $savedCommand = "SELECT * FROM saved WHERE user_id='$user_id' AND product_id='$product_id' LIMIT 1";
        $res = mysqli_query($con , $savedCommand);

        if($res == false){
            echo json_encode(array('error'=>true,'saved_select'=>false));
            exit();
        } else {
            $count = mysqli_num_rows($res);
            if($count > 0){
                // saved before so we should unsaved
                $command = "DELETE FROM saved WHERE user_id='$user_id' AND product_id='$product_id'";
                $res = mysqli_query($con , $command);
                if($res === false){

                } else {
                    echo json_encode(array('success'=>true,'delete'=>true));
                }
            } else {
                // not saved yet so we should saved it
                $command = "INSERT INTO saved (user_id,product_id) VALUES ('$user_id','$product_id')";
                $res = mysqli_query($con , $command);
                if($res === false){

                } else {
                    echo json_encode(array('success'=>true,'insert'=>true));
                }
            }
            
        }
    } else {
        echo json_encode(array('error'=>true,'user_count'=>false));
        exit();
    }
}




?>