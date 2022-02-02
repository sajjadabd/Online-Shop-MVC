<?php
require_once('../connect.php');
require_once('../functions.php');

//echo json_encode(array('phone'=>$_POST['phone'],'sms'=>$_POST['sms']));
//exit();

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$phone = phoneSanitize($_POST['phone']);
$sms = myFirstSanitize($_POST['sms']);


if($phone === false || $sms === false ){
    echo json_encode(array('sanitize'=>false));
    exit();
}

$checkAdmin = "SELECT * FROM adminTable WHERE phone='$phone' AND sms='$sms'";
$res = mysqli_query($con , $checkAdmin);

if($res === false){
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        $_SESSION['admin_phone'] = $phone;
        $_SESSION['admin_sms'] = $sms;
        
        echo json_encode(array('success'=>true));
        exit();
    } else {
        echo json_encode(array('count'=>0));
        exit();
    }
}

?>