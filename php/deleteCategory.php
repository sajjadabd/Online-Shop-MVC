<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['category_id'])){

} else {
    echo json_encode(array('success'=>false));
    exit();
}

$category_id = myFirstSanitize($_POST['category_id']);

if($category_id === false){
    echo json_encode(array('success'=>false));
    exit();
}


$deleteCategory = "DELETE FROM categories WHERE category_id='$category_id'";
$res = mysqli_query($con , $deleteCategory);

if($res === false){
    echo json_encode(array('success'=>false));
    exit();
} else {
    echo json_encode(array('success'=>true,'category_id'=>$category_id));
    exit();
}


?>