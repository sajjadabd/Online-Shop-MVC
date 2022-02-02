<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//category_id
//order

if( isset($_POST['category_id']) && isset($_POST['order']) ) {
    //echo json_encode(array('category_id'=>$_POST['category_id'],'order'=>$_POST['order']));
    //exit();
} else {
    echo json_encode(array('set'=>false));
    exit();
}


$category_id = myFirstSanitize($_POST['category_id']);
$order = myFirstSanitize($_POST['order']);

if( $category_id === false || $order === false ) {
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

$selectCategory = "SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1";
$res = mysqli_query($con, $selectCategory);

while($row = mysqli_fetch_array($res)) {
    $category_order = $row['category_order'];
}

$updateOrder = $category_order + $order;

$changeCategoryOrder = "UPDATE categories SET category_order='$updateOrder' WHERE category_id='$category_id'";
$res = mysqli_query($con, $changeCategoryOrder);

if($res === false) {
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    echo json_encode(array('sucess'=>true,'update_order'=>$updateOrder));
    exit();
}

?>