<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');


if(isset($_POST['product_id'])){
	
} else {
	echo json_encode(array('success'=>false,'set'=>false));
	exit();
}

$product_id = myFirstSanitize($_POST['product_id']);


if($product_id === false){
	echo json_encode(array('success'=>false,'sanitize'=>false));
	exit();
} else {
	
}


$selectAllProducts = "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1";
$res = mysqli_query($con, $selectAllProducts);

$returnProductResult = array();

if($res == false)
{
    // Error On Select products
}
else
{
    while( $row = mysqli_fetch_array($res) )
    {
        $returnProductResult = $row;
    }
	$result['success'] = true;
}

echo json_encode($returnProductResult);

?>