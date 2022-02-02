<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$selectComplains = "SELECT * FROM complains ORDER BY complain_id DESC LIMIT 10";
$res = mysqli_query($con, $selectComplains);

$complains = array();
if($res === false){
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    $count_complains = mysqli_num_rows($res);
    if($count_complains > 0){
        while($row = mysqli_fetch_array($res)){
            $complains[] = $row;
        }
    } else {
        echo json_encode($complains);
        exit();
    }
}

echo json_encode($complains);
exit();
?>