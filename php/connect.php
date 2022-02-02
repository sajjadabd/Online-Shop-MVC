<?php
session_start();
date_default_timezone_set("Asia/Tehran");

$result = array();

$servername = "localhost";
$username   = "root";
$password   = "";

$servername = ini_get('5.144.130.35:2082');
$username = "nekabeau";
$password = "sjabd123!@#123!@#";

$db_name = "membership";
$db_name = "nekabeau_membership";

$con = mysqli_connect($servername,$username,$password);
mysqli_query($con,"SET CHARACTER SET 'utf8mb4'");
mysqli_query($con,"SET SESSION collation_connection ='utf8mb4_persian_ci'");

if($con == false) {
    //$result['database_connect'] = false; //Database Connection Error
} else {
    //$result['database_connect'] = true; //Database Connect Successfully
}


$db_connect = mysqli_select_db($con, $db_name);

if(empty($db_connect)) {
    //$result['select_db'] = $db_connect;
	// CHARACTER SET utf8 COLLATE utf8_general_ci
	// CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; -- > This Works Great
    $databaseCreate = "CREATE DATABASE membership CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
    $check = mysqli_query($con , $databaseCreate);

    if( $check == false ) {
        //$result['db_create'] = $check; //Database Create Error
    } else {
        //$result['db_create'] = $check; //Database Create Successfully
    }
} else {
    //$result['select_db'] = $db_connect; //Database Already Exist
}

$db_connect = mysqli_select_db($con, $db_name);


//require_once('connectAndBuild2.php');


?>