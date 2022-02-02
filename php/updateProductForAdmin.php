<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//echo json_encode(print_r($_POST));
//echo json_encode(print_r($_FILES));
//exit();

$fileResult = array();

//$test = array();

$check1 = isset($_POST['title']);
$check2 = isset($_POST['category']);
$check3 = isset($_POST['brand']);
$check4 = isset($_POST['price']);
$check5 = isset($_FILES['myFile']);
$check6 = isset($_POST['original']);
$check7 = isset($_POST['stock']);


if( ! ( $check1 && $check2 && $check3 && $check4 && $check6 && $check7 ) ) {
    echo json_encode(array('set'=>false));
    exit();
}


if( empty($_POST['title']) || empty($_POST['category']) 
    || empty($_POST['brand']) || empty($_POST['price']) 
	|| empty($_POST['original'])  ){
	echo json_encode(array('empty'=>true));
    exit();
}

$product_id        = myStringSanitize($_POST['product_id']);
$title             = myStringSanitize($_POST['title']);
$category          = myStringSanitize($_POST['category']);
$brand             = myStringSanitize($_POST['brand']);
$description       = myStringSanitize($_POST['description']);
$stock             = myStringSanitize($_POST['stock']);
$price             = myStringSanitize($_POST['price']);
$original          = myStringSanitize($_POST['original']);
$color             = myStringSanitize($_POST['color']);


if(isset($_FILES['myFile'])) {
	$picture = $_FILES['myFile'];
}


if( $title === false || $category === false || $brand === false || $price === false 
    || $original === false || $description === false || $color === false){
	echo json_encode(array('sanitize'=>false));
    exit();
}


//echo json_encode(print_r($_FILES));
//echo json_encode(print_r($_POST));
//exit();

function checkPicturesAndUploadThemFirstPicture($picture,$index){
	
	$fileResult = array();
	
	$fileResult['file_name']  = $picture['name'][$index];
	$fileResult['file_temp']  = $picture['tmp_name'][$index];
	$fileResult['file_size']  = $picture['size'][$index];
	$fileResult['file_error'] = $picture['error'][$index];

	$file_ext = explode('.',$fileResult['file_name']);
	$file_ext = strtolower(end($file_ext));
	$fileResult['extension'] = $file_ext;

	$allowed = array('png','jpeg','jpg');

	if(in_array($file_ext, $allowed)){
		if($fileResult['file_error'] == 0){
			if($fileResult['file_size'] <= 1048576) { //1048576 === 1MB
				$file_name_new = uniqid('',true).'.'.$file_ext;
				$fileResult['file_name_new'] = $file_name_new;
				$file_destination = '../uploads/' . $file_name_new;
				$fileResult['destination'] = $file_destination;
				
				
				//return $fileResult;
				
				if(move_uploaded_file($fileResult['file_temp'], $file_destination)){

					$final_file_destination = '/uploads/'.$file_name_new;
					return $final_file_destination;

				} else {
					return false;
				}
			}
		}
	}
}





if( $check1 && $check2 && $check3 && $check4 ) {
	if(!empty($picture['name'][0])) {
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,0);
		$fileResult['first_file'] = $file_destination;

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
		

		// DELETE OLD Pictures
		$deletePictures = "DELETE FROM pictures WHERE product_id='$product_id'";
		$res = mysqli_query($con, $deletePictures);
		if($res === false){
			$fileResult['pictures_delete_success'] = false;
		} else {
			$fileResult['pictures_delete_success'] = true;
		}

		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$product_id','$file_destination','$title')";
		$res = mysqli_query($con, $insertPicture);
		if($res === false){
			$fileResult['picture1_update_success'] = false;
		} else {
			$fileResult['picture1_update_success'] = true;
		}
	}	
	if(!empty($picture['name'][1])){
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,1);
		$fileResult['second_file'] = $file_destination;
		
		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$product_id','$file_destination','$title')";
		$res = mysqli_query($con, $insertPicture);
		if($res === false){
			$fileResult['picture2_update_success'] = false;
		} else {
			$fileResult['picture2_update_success'] = true;
		}
	}
	if(!empty($picture['name'][2])){
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,2);
		$fileResult['third_file'] = $file_destination;
		
		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$product_id','$file_destination','$title')";
		$res = mysqli_query($con, $insertPicture);
		if($res === false){
			$fileResult['picture3_update_success'] = false;
		} else {
			$fileResult['picture3_update_success'] = true;
		}
	} 
		
	$addItem = "UPDATE products SET 
				title='$title',
				category='$category',
				brand='$brand',
				description='$description',
				product_color='$color',
				stock='$stock',
				price='$price',
				original='$original'
				WHERE product_id='$product_id'";

	$check = mysqli_query($con , $addItem);
	//$current_product_id = mysqli_insert_id($con);

	if($check == false){
		//ERROR INERT ITEM
		$fileResult['fourth_insert_success'] = false;
	}
	else{
		$fileResult['fourth_insert_success'] = true;
	}


	$deleteSomeOrders = "DELETE FROM orders WHERE product_id='$product_id' AND multiply>'$stock' AND activation='0'";
	$deleteSomeOrdersRes = mysqli_query($con, $deleteSomeOrders);

	if($deleteSomeOrdersRes === false){
		$fileResult['order_delte'] = false;
	} else {
		$fileResult['order_delte'] = true;
	}
	
} else {
    //Make Sure Fill Every Input Variables
    $fileResult['success'] = false;
}

echo json_encode($fileResult);

?>