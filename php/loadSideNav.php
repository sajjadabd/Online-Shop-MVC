<?php
require_once('connect.php');

$selectAllCategories = "SELECT * FROM categories ORDER BY category_order";
$res = mysqli_query($con, $selectAllCategories);

$returnOrders = array();

if($res == false) {
    // Error On Select categories
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $returnOrders[] = $row;
    }
}

echo json_encode($returnOrders);
?>