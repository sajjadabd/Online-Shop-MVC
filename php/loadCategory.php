<?php
require_once('connect.php');


$return = array();

//echo json_encode(print_r($_POST));
//exit();

$checkCategory = "SELECT * FROM categories ORDER BY category_order";
$res = mysqli_query($con , $checkCategory);

if($res == false){
    //$return['success'] = false;
} else {
    $count = mysqli_num_rows($res);
    if($count > 0){
        while( $row = mysqli_fetch_array($res) )
        {
            $return[] = $row;
        }
        $result['success'] = true; 
    } else {
        echo json_encode(array('count'=>$count));
        exit();
    }
    
}

echo json_encode($return);

?>