<?php
session_start();
// remove all session variables
session_unset();

setcookie("admin_phone", "", time() - 3600, "/");
setcookie("admin_sms", "", time() - 3600, "/");

// destroy the session
session_destroy(); 

//$redirect = "../home/index";
//header("Location: $redirect");

?>