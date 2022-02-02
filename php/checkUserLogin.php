<?php
require_once('connect.php');
require_once('functions.php');

function sessionUnset(){
    session_unset();
}


if( isset($_SESSION['phone']) && isset($_SESSION['sms']) ){
    $phone = $_SESSION['phone'];
    $sms = $_SESSION['sms'];

    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
        echo json_encode(array('session'=>true,'db_error'=>true));
        exit();
    } else{
        $count_user = mysqli_num_rows($res);
        if( $count_user > 0 ){
            echo json_encode(array(
                'session'=>true,
                'success'=>true,
                'phone'=>$phone,
                'sms'=>$sms,
                ));
            
            //setcookie('phone', $phone, time() + (86400 * 30), "/");
            //setcookie('sms', $sms, time() + (86400 * 30), "/");
            
            exit();
        } else {
            echo json_encode(array('session'=>true,'success'=>false));
            //setcookie('phone', '', time() - (86400 * 30), "/");
            //setcookie('sms', '', time() - (86400 * 30), "/");
            sessionUnset();
            exit();
        }
    }
}

if( isset($_COOKIE['phone']) && isset($_COOKIE['sms']) ) {
    $phone = $_COOKIE['phone'];
    $sms =  $_COOKIE['sms'];

    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);

    if($res === false){
         echo json_encode(array('cookies'=>true,'db_error'=>true));
         exit();
    } else{
        $count_user = mysqli_num_rows($res);
        if($count_user > 0 ){
            echo json_encode(array(
                'cookies'=>true,
                'success'=>true,
                'phone'=>$phone,
                'sms'=>$sms,
                ));
            
            $_SESSION['phone'] = $phone;
            $_SESSION['sms'] = $sms;
            
            exit();
            //setcookie('phone', $phone, time() + (86400 * 30), "/");
            //setcookie('sms', $sms, time() + (86400 * 30), "/");
        } else {
            echo json_encode(array('cookies'=>true,'success'=>false));
            //setcookie('phone', $phone, time() - (86400 * 30), "/");
            //setcookie('sms', $sms, time() - (86400 * 30), "/");
            exit();
        }
    }
} 

if( isset($_POST['phone']) && isset($_POST['sms']) ){
    $phone = myFirstSanitize($_POST['phone']);
    $sms = myFirstSanitize($_POST['sms']);
    
    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);
    
    
    if($res === false){
        echo json_encode(array('localStorage'=>true,'db_error'=>true));
        exit();
    } else {
        $count_user = mysqli_num_rows($res);
    
        if($count_user > 0){
            
            echo json_encode(array(
                'localStorage'=>true,
                'success'=>true,
                'phone'=>$phone,
                'sms'=>$sms,
                ));
            exit();
            
        } else {
            
            echo json_encode(array('localStorage'=>true,'success'=>false));
            //setcookie('phone', $phone, time() - (86400 * 30), "/");
            //setcookie('sms', $sms, time() - (86400 * 30), "/");
            exit();
            
        }
    }
    
} else {
    echo json_encode(array(
        'localStorage'=>false,
        'session'=>false,
        'cookies'=>false,
        'success'=>false));
    //setcookie('phone', $phone, time() - (86400 * 30), "/");
    //setcookie('sms', $sms, time() - (86400 * 30), "/");
    exit();
}

?>