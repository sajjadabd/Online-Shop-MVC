<?php
session_start();

//echo 'LogOut';
function sessionUnset(){
    
    setcookie("phone", $phone, time() - (86400 * 30), "/");
    setcookie("sms", $sms, time() - (86400 * 30), "/");
                
                
    session_unset();
    session_destroy();

    $redirect = "https://nekabeauty.com/home/shop/";
    header("Location: $redirect");
    exit();
}

sessionUnset();

?>