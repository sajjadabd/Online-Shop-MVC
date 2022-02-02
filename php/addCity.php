<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//echo json_encode($_POST);
//exit();

if( isset($_POST['province']) 
	&& isset($_POST['city']) 
    && isset($_POST['post_price'])
    && isset($_POST['rural_post_price']) ){
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}

if(empty($_POST['province']) || empty($_POST['city']) || empty($_POST['post_price'])){
	echo json_encode(array('empty'=>true));
	exit();
}

$city_name = myStringSanitize($_POST['city']);
$province_name = myStringSanitize($_POST['province']);
$post_price = myFirstSanitize($_POST['post_price']);
$rural_post_price = myFirstSanitize($_POST['rural_post_price']);

if( $province_name === false 
    || $city_name === false 
	|| $post_price === false
	|| $rural_post_price === false ){
	echo json_encode(array('sanitize'=>false));
	exit();
}


$getProvince = "SELECT * FROM provinces WHERE province_name='$province_name'";
$res = mysqli_query($con , $getProvince);

if($res === false){
	
} else {
	$count_province = mysqli_num_rows($res);
	if($count_province > 0){
		while($row = mysqli_fetch_array($res)){
			$province_id = $row['province_id'];
		}
	} else {
		echo json_encode(array('province'=>false));
		exit();
	}
}

$detectOrder = "SELECT * FROM cities";
$detectOrderRes = mysqli_query($con , $detectOrder);

if($detectOrderRes === false){
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    $city_order = mysqli_num_rows($detectOrderRes);
    $city_order += 1;
}


$checkProvince = "SELECT * FROM cities WHERE city_name='$city_name' AND province_name='$province_name'";
$res = mysqli_query($con , $checkProvince);

if($res === false){
	echo json_encode(array('db_error1'=>true));
	exit();
} else {
	$count = mysqli_num_rows($res);
	if($count > 0){
		//echo json_encode(array('count'=>$count));
		//exit();
		$updateCity = "UPDATE cities SET post_price='$post_price',rural_post_price='$rural_post_price' 
						WHERE city_name='$city_name' AND province_name='$province_name'";
		
		$res = mysqli_query($con , $updateCity);

		if($res === false){
			echo json_encode(array('db_error2'=>true));
			exit();
		} else {
			echo json_encode(array('success'=>true));
			exit();
		}
	} else {
		$addCity = "INSERT INTO cities (city_name,post_price,rural_post_price,city_order,province_id,province_name) VALUES 
					('$city_name','$post_price','$rural_post_price','$city_order','$province_id','$province_name')";
		
		$res = mysqli_query($con , $addCity);

		if($res === false){
			echo json_encode(array('db_error3'=>true));
			exit();
		} else {
			echo json_encode(array('success'=>true));
			exit();
		}
	}
}


?>