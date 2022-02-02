<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

//echo json_encode($_POST);
//exit();

if(isset($_POST['province'])){
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}

if(empty($_POST['province'])){
	echo json_encode(array('empty'=>true));
	exit();
}

$province_name = myStringSanitize($_POST['province']);

if($province_name === false) {
	echo json_encode(array('sanitize'=>false));
	exit();
}


$detectOrder = "SELECT * FROM provinces";
$detectOrderRes = mysqli_query($con , $detectOrder);

if($detectOrderRes === false){
    echo json_encode(array('db_error'=>true));
    exit();
} else {
    $province_order = mysqli_num_rows($detectOrderRes);
    $province_order += 1;
}


$checkProvince = "SELECT * FROM provinces WHERE province_name='$province_name'";
$res = mysqli_query($con , $checkProvince);

if($res === false){
	echo json_encode(array('db_error1'=>true));
	exit();
} else {
	$count = mysqli_num_rows($res);
	if($count > 0){
		echo json_encode(array('count'=>$count));
		exit();
	} else {
		$addProvince = "INSERT INTO provinces (province_name,province_order) VALUES
						 ('$province_name', '$province_order')";
		
		$res = mysqli_query($con , $addProvince);

		if($res === false){
			echo json_encode(array('db_error2'=>true));
			exit();
		} else {
			echo json_encode(array('success'=>true));
			exit();
		}
	}
}


?>