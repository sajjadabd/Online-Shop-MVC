<?php
require_once('connect.php');
require_once('functions.php');

echo json_encode($_GET);
exit();

$selectAllProducts = "SELECT * FROM products LIMIT 10";
$res = mysqli_query($con, $selectAllProducts);

$returnProducts = array();

if($res == false) {
    // Error On Select products
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $returnProducts[] = $row;
    }
	$result['success'] = true;
}

echo json_encode($returnProducts);

?>