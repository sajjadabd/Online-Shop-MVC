<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$selectDISTINCTViews = "SELECT COUNT(DISTINCT ip_address) As NumberOfPeople FROM visit";
$res = mysqli_query($con, $selectDISTINCTViews);


if($res == false) {
    // Error On Select views
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $distinct = $row['NumberOfPeople'];
    }
}

echo json_encode(array('distinct'=>$distinct));

?>