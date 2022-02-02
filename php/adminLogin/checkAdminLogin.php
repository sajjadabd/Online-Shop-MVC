<?php
require_once('../connect.php');
require_once('../functions.php');
require_once('admin_checkBlocked.php');

//echo json_encode(print_r($_POST));
//exit();

$adminResult = array();

require_once('admin_hacker_scanner.php');

if( isset($_POST['phone']) && !isset($_POST['sms']) ){
    
    $phone = phoneSanitize($_POST['phone']);

    if( $phone === false ){
        echo json_encode(array('success'=>false,'phone_set'=>true,'sanitize'=>false));
        exit();
    }

    if( $phone != "09381308994" ){
        echo json_encode(array('success'=>false,'phone_set'=>true,'admin'=>false));
        exit();
    }

    $randomNumber = mt_rand(10000,100000);
    //$adminResult['randomNumber'] = $randomNumber;
    $updateSms = "UPDATE adminTable SET sms='$randomNumber' WHERE phone='$phone' LIMIT 1";
    $res = mysqli_query($con , $updateSms);

    if($res === false){
        echo json_encode(array('success'=>false,'database_error'=>true));
        exit();
    } else {
        echo json_encode(array('success'=>true,'refresh_sms'=>true));
		send_sms13671($phone,$randomNumber);
        exit();
    }

} else if ( isset($_POST['phone']) && isset($_POST['sms']) ){
    //echo json_encode(array('phone_set'=>true,'sms_set'=>false));
    //exit();
    $phone = phoneSanitize($_POST['phone']);
    $sms   = myFirstSanitize($_POST['sms']);

    if($phone === false || $sms === false){
        echo json_encode(array('success'=>false,'phone_set'=>true,'sanitize'=>false));
        exit();
    }

    if( $phone != "09381308994" ){
        echo json_encode(array('success'=>false,'phone_set'=>true,'admin'=>false));
        exit();
    }

    $checkForAdmin = "SELECT * FROM adminTable WHERE phone='$phone' AND sms='$sms'";
    $res = mysqli_query($con, $checkForAdmin);

    if($res === false){
        echo json_encode(array('success'=>false,'database_error'=>true));
        exit();
    } else {
        $count = mysqli_num_rows($res);
        $return = array();
        if($count > 0){

            $_SESSION['admin_phone'] = $phone;
            $_SESSION['admin_sms']   = $sms;
			
			
			setcookie("admin_phone", $phone, time() + (86400 * 30), "/");
            setcookie("admin_sms", $sms, time() + (86400 * 30), "/");

            while($row = mysqli_fetch_array($res)){
                $return = $row;
            }

            echo json_encode($return);
            
            //set hacker_attack of this ip_address to zero
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $to_date = date("Y-m-d h:i:sa");
            
            $setAttackZero = "UPDATE adminattack SET hacker_attack='0',date='$to_date' WHERE ip_address='$ip_address'";
            $setAttackZeroRes = mysqli_query($con, $setAttackZero);
        }
    }


} else {
    echo json_encode(array('success'=>false,'phone_set'=>false,'sms_set'=>false));
    exit();
}

?>