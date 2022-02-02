<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$return = array();
$return['success'] = false;

//echo json_encode(print_r($_POST));
//exit();

if(isset($_POST['category'])){
    
} else {
    $return['set'] = false;
    echo json_encode($return);
    exit();
}

$category_name = myStringSanitize($_POST['category']);

if( empty($category_name) || $category_name === false ){
    $return['empty'] = true;
    $return['sanitize'] = false;
    echo json_encode($return);
    exit();
}


$detectOrder = "SELECT * FROM categories";
$detectOrderRes = mysqli_query($con , $detectOrder);

if($detectOrderRes === false){
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    $category_order = mysqli_num_rows($detectOrderRes);
    $category_order += 1;
}


$checkCategory = "SELECT * FROM categories WHERE category_name='$category_name'";
$res = mysqli_query($con , $checkCategory);

if($res == false){
    $return['db_error'] = true;
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        $return['we_have'] = true;
        echo json_encode($return);
        exit();
    } else {

        $addCategory = "INSERT INTO categories (category_name,category_order) VALUES ('$category_name','$category_order')";
        $res = mysqli_query($con , $addCategory);
        
        if($res == false) {
            // Error On Select users
            $return['can_not_insert'] = true;
            $return['success'] = false;
        } else {
            /*while( $row = mysqli_fetch_array($res) )
            {
                $return[] = $row;
            }*/
            $return['success'] = true;
            $result['success'] = true;
        }
    }
}

echo json_encode($return);

?>