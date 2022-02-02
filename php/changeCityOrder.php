<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//city_id
//order

if( isset($_POST['city_id']) && isset($_POST['order']) ) {
    //echo json_encode(array('city_id'=>$_POST['city_id'],'order'=>$_POST['order']));
    //exit();
} else {
    echo json_encode(array('set'=>false));
    exit();
}

$city_id = myFirstSanitize($_POST['city_id']);
$order = myFirstSanitize($_POST['order']);

if( $city_id === false || $order === false ) {
    echo json_encode(array('sanitize'=>false));
    exit();
} else {
    
}




if( $order == 1 ) {

} else if( $order == -1 ) {

} else {
    echo json_encode(array('order_number'=>false));
    exit();
}

$selectCity = "SELECT * FROM cities WHERE city_id='$city_id' LIMIT 1";
$res = mysqli_query($con, $selectCity);

while($row = mysqli_fetch_array($res)){
    $city_order = $row['city_order'];
}

$updateOrder = $city_order + $order;

$changeCityOrder = "UPDATE cities SET city_order='$updateOrder' WHERE city_id='$city_id'";
$res = mysqli_query($con, $changeCityOrder);

if($res === false) {
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    echo json_encode(array('sucess'=>true,'update_order'=>$updateOrder));
    exit();
}



?>