<?php
require_once('connect.php');

function kickout(){
    //session_unset();
    //session_destroy();
    $domain = "https://nekabeauty.com/home/shop/";
    header("Location: $domain");
    //require_once('error404.php');
    exit();
}


if(isset($_SESSION['admin_phone']) && isset($_SESSION['admin_sms'])){
    $phone = $_SESSION['admin_phone'];
    $sms = $_SESSION['admin_sms'];

    $checkUser = "SELECT * FROM admintable WHERE phone='$phone' AND sms='$sms'";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
         
    } else{
        $count_user = mysqli_num_rows($res);
        if( $count_user > 0 ){

        } else {
            kickout();
        }
    }
} else if (isset($_COOKIE["admin_phone"]) && isset($_COOKIE["admin_sms"])) {
    $phone = $_COOKIE["admin_phone"];
    $sms =  $_COOKIE["admin_sms"];

    $checkUser = "SELECT * FROM admintable WHERE phone='$phone' AND sms='$sms'";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
         
    } else{
        $count_user = mysqli_num_rows($res);
        if($count_user > 0 ){
            
            $_SESSION['admin_phone'] = $phone;
            $_SESSION['admin_sms'] = $sms;

            setcookie("admin_phone", $phone, time() + (86400 * 30), "/");
            setcookie("admin_sms", $sms, time() + (86400 * 30), "/");
            
        } else {
            //sessionUnset();
            kickout();
        }
    }
} else {
    kickout();
}

?>