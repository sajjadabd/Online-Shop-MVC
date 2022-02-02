<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

if(isset($_POST['searchTerm'])) {
	
} else {
	echo json_encode(array('set'=>false));
	exit();
}

$searchTerm = myStringSanitize($_POST['searchTerm']);
$start = myFirstSanitize($_POST['start']);

$searchViews = "SELECT * FROM visit 
				   WHERE date LIKE '%$searchTerm%' 
                   ORDER BY visit_id DESC
				   LIMIT 10 OFFSET $start";
				   
$res = mysqli_query($con, $searchViews);

$returnViews = array();

if($res == false) {
    // Error On Select Users
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $returnViews[] = $row;
    }
}

echo json_encode($returnViews);

?>