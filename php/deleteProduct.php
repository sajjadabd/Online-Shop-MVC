<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['product_id'])) {
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}

$product_id = myFirstSanitize($_POST['product_id']);

if($product_id === false) {
	echo json_encode(array('sanitize'=>false));
	exit();
}


$deleteProducts = "DELETE FROM products WHERE product_id='$product_id'";
$res = mysqli_query($con, $deleteProducts);


$deleteOrdersOfThisProduct = "DELETE FROM orders WHERE product_id='$product_id' AND activation='0'";
$res = mysqli_query($con, $deleteOrdersOfThisProduct);

$selectPicturesOfThisProduct = "SELECT * FROM pictures WHERE product_id='$product_id'";
$res = mysqli_query($con , $selectPicturesOfThisProduct);

if($res === false){

} else {
	$count = mysqli_num_rows($res);
	if($count > 0){
		while($row = mysqli_fetch_array($res)) {
			$picture_destination = $row['file_destination'];
			$picture_destination = '..' . $picture_destination;
			unlink($picture_destination);
		}
	} else {

	}
}

$deletePicturesOfThisProduct = "DELETE FROM pictures WHERE product_id='$product_id'";
$res = mysqli_query($con , $deletePicturesOfThisProduct);


if($res == false) {
    // Error On Select products
} else {
    echo json_encode(array('success'=> true));
}

?>