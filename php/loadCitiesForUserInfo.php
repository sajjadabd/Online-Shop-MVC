<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['phone']) && isset($_POST['sms']) && isset($_POST['province_name'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}


$phone = myFirstSanitize($_POST['phone']);
$sms = myFirstSanitize($_POST['sms']);
$province_name = myStringSanitize($_POST['province_name']);

if( $phone === false || $sms === false || $province_name === false ){
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
            $user_city = $row['city'];
        }
    }
}


$loadCities = "SELECT * FROM cities WHERE province_name='$province_name' ORDER BY city_order";
$res = mysqli_query($con , $loadCities);

$returnCities = array();

if($res === false) {
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        while($row = mysqli_fetch_array($res)){
            $returnCities[] = $row;
        }
    } else {
        echo json_encode($returnCities);
        exit();
    }
}

echo json_encode(array('cities'=>$returnCities,'user_city'=>$user_city));

?>