<?php
session_start();
require_once('../connect.php');
require_once('../functions.php');

// remove all session variables
session_unset();

// destroy the session
session_destroy(); 

?>