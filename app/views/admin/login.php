<?php
require_once('url_checker.php');
?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    
    <?php
        require_once("css/cssAdminLogin.php");
        require_once("css/cssGlobal.php");
    ?>

    <script src="/js/src/sweetalert2.8.js"></script>

    <title>Neka Beauty</title>
</head>


<body>
    
    <div class="header">
        <div class="logo">Neka Beauty</div>
    </div>


    <div class="form-container">
        
        <form onsubmit="return false;">

            <div class="logoBig">Neka Beauty</div>
            
            <input  class="textInput" id="phone" placeholder="Enter Phone Number" type="phone" name="phone" autocomplete="off">

            <input style="display:none;" class="textInput" id="sms" placeholder="Enter The Code" type="text" name="sms" autocomplete="off">
            
            
            <div class="buttonContainer">
                <button id="next">Next</button>
                <button style="display:none;" id="enter">Enter</button>
                <button style="display:none;" id="back"><i class="fas fa-arrow-left"></i></button>
            </div>
        </form>
    </div>

    <div class="overFooter">
        <a href="index.php">nekabeauty.com</a>
    </div>

    
    <div class="footer">

    </div>


	<script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/admin/adminLogin.js"></script>



</body>

</html>