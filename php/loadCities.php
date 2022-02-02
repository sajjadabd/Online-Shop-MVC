<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST['province_name'])){

} else {
    echo json_encode(array('set'=>false));
    exit();
}

$province_name = myStringSanitize($_POST['province_name']);

if($province_name === false){
    echo json_encode(array('sanitize'=>false));
    exit();
} else {

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

echo json_encode($returnCities);

?>