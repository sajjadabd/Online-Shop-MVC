<?php
require_once('connect.php');

function sessionUnset(){
    session_unset(); 
    //session_destroy();
}


if(isset($_SESSION['phone']) && isset($_SESSION['sms'])){
    //echo json_encode(array('session'=>true));
    //exit();
    $phone = $_SESSION['phone'];
    $sms = $_SESSION['sms'];

    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
         
    } else{
        $count_user = mysqli_num_rows($res);
        if( $count_user > 0 ){
            //echo json_encode(array('success'=>true));
            
        } else {
            sessionUnset();
        }
    }
} else if(isset($_COOKIE['phone']) && isset($_COOKIE['sms'])) {
    $phone = $_COOKIE['phone'];
    $sms = $_COOKIE['sms'];

    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
         
    } else{
        $count_user = mysqli_num_rows($res);
        if($count_user > 0 ){
            //echo json_encode(array('success'=>true));
            $_SESSION['phone'] = $phone;
            $_SESSION['sms'] = $sms;

            //setcookie('phone', $phone, time() + (86400 * 30), "/");
            //setcookie('sms', $sms, time() + (86400 * 30), "/");
        }
    }
} else {
    //echo json_encode(array('success'=>false));
    $domain = "https://nekabeauty.com/home/shop/";
    header("Location: $domain");
    exit();
}

?>