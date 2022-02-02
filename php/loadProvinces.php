<?php
require_once('connect.php');
require_once('functions.php');

$loadProvinces = "SELECT * FROM provinces ORDER BY province_order";
$res = mysqli_query($con , $loadProvinces);

$returnProvinces = array();

if($res === false) {
    echo json_encode(array('db_error'=>false));
    exit();
} else {
    $count = mysqli_num_rows($res);
    if($count > 0) {
        while($row = mysqli_fetch_array($res)){
            $returnProvinces[] = $row;
        }
    } else {
        echo json_encode($returnProvinces);
        exit();
    }
}

echo json_encode($returnProvinces);

?>