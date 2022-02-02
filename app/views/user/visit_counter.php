<?php
require_once('connect.php');
require_once('functions.php');
require_once('jdatetime.php');

date_default_timezone_set('Asia/Tehran');

$ip_address = $_SERVER['REMOTE_ADDR'];
                                    
$dateNow = jDateTime::date('l j F Y H:i');

$checkForDoubleInsertingBug = "SELECT * FROM visit WHERE ip_address='$ip_address' AND date='$dateNow'";
$res = mysqli_query($con ,$checkForDoubleInsertingBug);

$count_before = mysqli_num_rows($res);

if($count_before > 0){
    
} else {
    $insertToVisit = "INSERT INTO visit (ip_address,date) VALUES ('$ip_address','$dateNow')";
    $res = mysqli_query($con ,$insertToVisit);
    
    if($res === false) {
    	
    } else {
    	
    }
}


?>