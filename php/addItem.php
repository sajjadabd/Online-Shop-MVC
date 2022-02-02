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
$check6 = isset($_POST['stock']);

if( ! ($check1 && $check2 && $check3 && $check4 && $check5 && $check6) ) {
	$fileResult['success'] = false;
    echo json_encode($fileResult);
    exit();
}


if( empty($_POST['title']) || empty($_POST['category']) 
    || empty($_POST['brand']) || empty($_POST['price']) 
    || empty($_FILES['myFile']) || empty($_POST['stock']) ){
	$fileResult['success'] = false;
    $fileResult['empty'] = true;
    echo json_encode($fileResult);
    exit();
}

$title        = myStringSanitize($_POST['title']);
$category     = myStringSanitize($_POST['category']);
$brand        = myStringSanitize($_POST['brand']);
$description  = myStringSanitize($_POST['description']);
$price        = myStringSanitize($_POST['price']);
$stock        = myStringSanitize($_POST['stock']);
$original     = myStringSanitize($_POST['original']);
$color        = myStringSanitize($_POST['color']);
$picture      = $_FILES['myFile'];

if( $title === false || $category === false || $brand === false || 
    $price === false || $stock === false || $description === false || $color === false ) {
	$fileResult['success'] = false;
    $fileResult['sanitize'] = false;
    echo json_encode($fileResult);
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





if( $check1 && $check2 && $check3 && $check4 && $check5 ) {
	if(!empty($picture['name'][0])){
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,0);
		$fileResult['first_file'] = $file_destination;
		
		$addItem = "INSERT INTO products (title,category,brand,description,product_color,stock,price,original) VALUES 
		('$title','$category','$brand','$description','$color','$stock','$price','$original')";
	
		$check = mysqli_query($con , $addItem);
		$current_product_id = mysqli_insert_id($con);
	
		if($check == false){
			//ERROR INERT ITEM
			$fileResult['first_insert_success'] = false;
		}
		else{
			$fileResult['first_insert_success'] = true;
		}


		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$current_product_id','$file_destination','$title')";
		$check = mysqli_query($con , $insertPicture);
	
		if($check == false){
			//ERROR INERT ITEM
			$fileResult['first_insert_picture_success'] = false;
		}
		else{
			$fileResult['first_insert_picture_success'] = true;
		}

	}	
	if(!empty($picture['name'][1])){
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,1);
		$fileResult['second_file'] = $file_destination;
		
		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$current_product_id','$file_destination','$title')";

		$check = mysqli_query($con , $insertPicture);
	
		if($check == false){
			//ERROR INERT ITEM
			$fileResult['first_insert_picture2_success'] = false;
		}
		else{
			$fileResult['first_insert_picture2_success'] = true;
		}
	}
	if(!empty($picture['name'][2])){
		$file_destination = checkPicturesAndUploadThemFirstPicture($picture,2);
		$fileResult['third_file'] = $file_destination;
		
		$insertPicture = "INSERT INTO pictures (product_id,file_destination,picture_alt) VALUES 
							('$current_product_id','$file_destination','$title')";

		$check = mysqli_query($con , $insertPicture);
	
		if($check == false){
			//ERROR INERT ITEM
			$fileResult['first_insert_picture3_success'] = false;
		}
		else{
			$fileResult['first_insert_picture3_success'] = true;
		}
	}
} else {
    //Make Sure Fill Every Input Variables
    $fileResult['success'] = false;
}

echo json_encode($fileResult);

?>