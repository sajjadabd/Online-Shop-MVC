<?php
session_start();
require_once('url_checker.php');
require_once('checkAdmin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
        require_once("css/cssAdmin.php");
        require_once("css/cssGlobal.php");
    ?>

    <link rel="stylesheet" href="/css/admin_complains.css" />

    <title>Neka Beauty</title>
    <script src="/js/src/sweetalert2.8.js"></script>
</head>
<body>

    <?php
    require_once('header.php');
    ?>

    <div id="complainsContent">

    </div>
    


    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    
	<script src="/js/admin/showComplains.js"></script>
	<script src="/js/admin/logoff.js"></script>


</body>
</html>