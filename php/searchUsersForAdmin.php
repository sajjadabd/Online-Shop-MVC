<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['searchTerm'])){
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}

$searchTerm = myStringSanitize($_POST['searchTerm']);
$start = myFirstSanitize($_POST['start']);

$searchProducts = "SELECT * FROM users 
				   WHERE phone LIKE '%$searchTerm%' 
                   OR username LIKE '%$searchTerm%' 
                   OR address LIKE '%$searchTerm%'
                   ORDER BY user_id DESC
				   LIMIT 10 OFFSET $start";
				   
$res = mysqli_query($con, $searchProducts);

$returnUsers = array();

if($res == false) {
    // Error On Select Users
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $returnUsers[] = $row;
    }
}

echo json_encode($returnUsers);

?>