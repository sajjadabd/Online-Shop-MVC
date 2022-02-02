<?php
require_once('connect.php');
require_once('functions.php');
require_once('checkRealAdmin.php');

$start = myFirstSanitize($_POST['start']);

$selectAllViews = "SELECT * FROM visit ORDER BY visit_id DESC LIMIT 10 OFFSET $start";
$res = mysqli_query($con, $selectAllViews);

$views = array();

if($res == false) {
    // Error On Select views
} else {
    while( $row = mysqli_fetch_array($res) ) {
        $views[] = $row;
    }
}

echo json_encode($views);

?>