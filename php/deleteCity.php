<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['city_id'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$city_id = myFirstSanitize($_POST['city_id']);

if($city_id === false){
    echo json_encode(array('sanitize'=>false));
    exit();
}

$deleteCity = "DELETE FROM cities WHERE city_id='$city_id'";
$res = mysqli_query($con , $deleteCity);

if($res === false){
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    echo json_encode(array('success'=>true));
    exit();
}

?>