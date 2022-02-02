<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$start = myFirstSanitize($_POST['start']);

$selectAllOrders = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 20 OFFSET $start";

$res = mysqli_query($con, $selectAllOrders);

$returnOrders = array();

if($res == false) {
    // Error On Select orders
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $returnOrders[] = $row;
    }
	$result['success'] = true;
}

echo json_encode($returnOrders);

?>