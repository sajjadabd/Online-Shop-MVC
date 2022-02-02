<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['searchTerm'])){
	
} else {
	echo json_encode(array('success'=>false,'set'=>false));
	exit();
}

$searchTerm = myStringSanitize($_POST['searchTerm']);

$start = myFirstSanitize($_POST['start']);

$searchProducts = "SELECT products.*,pictures.* FROM products 
                   LEFT JOIN pictures ON products.product_id=pictures.product_id
				   WHERE title LIKE '%$searchTerm%' 
                   OR category LIKE '%$searchTerm%' 
				   OR brand LIKE '%$searchTerm%'
                   GROUP BY products.product_id 
                   ORDER BY products.product_id DESC
				   LIMIT 10 OFFSET $start";
				   
				   
$res = mysqli_query($con, $searchProducts);

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