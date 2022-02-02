<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}


$phone = myFirstSanitize($_POST['phone']);
$sms = myFirstSanitize($_POST['sms']);

if($phone === false || $sms === false){
    echo json_encode(array('sanitize'=>false));
    exit();
} else {

}

$selectUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
$res = mysqli_query($con , $selectUser);

if($res === false){

} else {
    $count_user = mysqli_num_rows($res);
    if($count_user > 0){
        while($row = mysqli_fetch_array($res)){
            $user_province = $row['province'];
        }
    }
}


$loadProvinces = "SELECT * FROM provinces ORDER BY province_order";
$res = mysqli_query($con , $loadProvinces);

$returnProvinces = array();

if($res === false) {
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        while($row = mysqli_fetch_array($res)){
            $returnProvinces[] = $row;
        }
    } else {
        echo json_encode($returnProvinces);
        exit();
    }
}

echo json_encode(array('provinces'=>$returnProvinces,'user_province'=>$user_province));

?>