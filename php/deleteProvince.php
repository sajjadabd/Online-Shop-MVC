<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['province_id'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$province_id = myFirstSanitize($_POST['province_id']);

if($province_id === false){
    echo json_encode(array('sanitize'=>false));
    exit();
}

$deleteCities = "DELETE FROM cities WHERE province_id='$province_id'";
$res = mysqli_query($con , $deleteCities);

if($res === false){
    echo json_encode(array('db_error'=>false));
    exit();
}

$deleteProvince = "DELETE FROM provinces WHERE province_id='$province_id'";
$res = mysqli_query($con , $deleteProvince);

if($res === false){
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    echo json_encode(array('success'=>true));
    exit();
}

?>