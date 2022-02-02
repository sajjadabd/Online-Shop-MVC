<?php
session_start();

require_once('url_checker.php');

?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    
    <script src="/js/src/sweetalert2.8.js"></script>
    
    <?php
        require_once("css/cssGlobal.php");
        require_once("css/cssUserLogin.php");
    ?>

    <title>Neka Beauty</title>
    
</head>

<body>
    
    <!-- <div class="header">

    </div> -->

    <?php
    require_once('svgHead.php');
    ?>


    <div class="form-container">
        <form onsubmit="return false;">

            <div class="logo"><h1><a href="https://nekabeauty.com/">Neka Beauty</a></h1></div>

            <div class="tab">
                <input class="textInput" id="phone" placeholder="شماره موبایل خود را وارد کنید" type="text" name="phone" autocomplete="off">
            </div>
            <div style="display:none;" class="tab">
                <input class="textInput" id="sms" placeholder="کد فرستاده شده را وارد کنید" type="text" name="sms" autocomplete="off">
            </div>
            <!--
            <div class="tab">
                <input class="textInput" placeholder="نام کاربری برای خود انتخاب کنید" type="text" name="username" autocomplete="off">
            </div>
            -->

            <div id="allButtons" class="buttons">
                <button style="display:none;" id="prev" class="submitButton" onclick="next(-1)" ><i class="fas fa-arrow-left"></i></button>
                <button id="nex" class="submitButton" >بعدی</button>
                <button style="display:none;" id="submit" class="submitButton" >ورود به فروشگاه</button>
            </div>


			<!---->
			<div style="display:none;" id="loading" class="loadingContainer">
				<div class="loading">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
            
			<!--
            <div class="lawAccept">
                ورود به نکا بیوتی به معنی پذیرفتن <a href="../laws">قوانین و مقررات</a> نکا بیوتی است
            </div>
			-->

        </form>
    </div>

    <div class="desc">
        <div>
            فروشگاه نکا بیوتی به عنوان اولین فروشگاه اینترنتی تخصصی لوازم آرایشی در نکا آماده ی خدمت رسانی به همه ی همشهریان عزیز می باشد
        </div>
    </div>

    

    <?php
        require_once('svgFooterWithOutZarinpal.php')
    ?>
	
	
	<div id="snackbar" class="snackbar">
		شماره ی وارد شده صحیح نمی باشد
    </div>
	
	<div id="snackbar2" class="snackbar">
		کد وارد شده صحیح نمی باشد
    </div>

    <div id="snackbar3" class="snackbar">
		شما به مدت <span id="blockTimeRemaining">...</span> دقیقه قادر به ورود به نکا بیوتی نیستید
    </div>
	
    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/src/cookiesHandler.js"></script>
    <script src="/js/user/login.js"></script>
    <script src="/js/user/login_jquery.js"></script>



</body>

</html>