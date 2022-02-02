<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//province_id
//order

if( isset($_POST['province_id']) && isset($_POST['order']) ) {
    //echo json_encode(array('province_id'=>$_POST['province_id'],'order'=>$_POST['order']));
    //exit();
} else {
    echo json_encode(array('set'=>false));
    exit();
}


$province_id = myFirstSanitize($_POST['province_id']);
$order = myFirstSanitize($_POST['order']);

if( $province_id === false || $order === false ) {
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

$selectProvince = "SELECT * FROM provinces WHERE province_id='$province_id' LIMIT 1";
$res = mysqli_query($con, $selectProvince);

while($row = mysqli_fetch_array($res)) {
    $province_order = $row['province_order'];
}

$updateOrder = $province_order + $order;

$changeProvinceOrder = "UPDATE provinces SET province_order='$updateOrder' WHERE province_id='$province_id'";
$res = mysqli_query($con, $changeProvinceOrder);

if($res === false) {
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    echo json_encode(array('sucess'=>true,'update_order'=>$updateOrder));
    exit();
}



?>