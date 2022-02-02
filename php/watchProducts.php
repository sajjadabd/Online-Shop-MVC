<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$start = myFirstSanitize($_POST['start']);


//$selectAllProducts = "SELECT * FROM products ORDER BY product_id DESC LIMIT 10";
$selectAllProducts = "SELECT products.*,pictures.* FROM products 
                        LEFT JOIN pictures ON products.product_id=pictures.product_id 
                        GROUP BY products.product_id ORDER BY products.product_id 
                        DESC  LIMIT 10 OFFSET $start";

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