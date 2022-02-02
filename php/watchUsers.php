<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$start = myFirstSanitize($_POST['start']);

$selectAllUsers = "SELECT * FROM users ORDER BY user_id DESC LIMIT 10 OFFSET $start";
$res = mysqli_query($con, $selectAllUsers);

$users = array();

if($res == false) {
    // Error On Select users
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $users[] = $row;
    }
	
	$result['success'] = true;
}

echo json_encode($users);

?>