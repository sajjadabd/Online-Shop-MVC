<?php

$servername = "localhost";
$username   = "root";
$password   = "";

$servername = ini_get('5.144.130.35:2082');
$username = "nekabeau";
$password = "sjabd123!@#123!@#";

$db_name = "membership";
$db_name = "nekabeau_membership";

$con = mysqli_connect($servername,$username,$password);

$db_connect = mysqli_select_db($con, $db_name);

mysqli_query($con,"SET CHARACTER SET 'utf8mb4'");
mysqli_query($con,"SET SESSION collation_connection ='utf8mb4_persian_ci'");

?>