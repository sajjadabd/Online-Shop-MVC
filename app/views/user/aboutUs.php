<?php
session_start();

require_once('url_checker.php');

?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <?php
        require_once('meta_tags.php');
    ?>
    
    
    <?php
        require_once("css/cssGlobal.php");
        require_once("css/cssUserLogin.php");
    ?>
    
    <link rel="stylesheet" href="/css/laws.css"/>
    <link rel="stylesheet" href="/css/aboutUs.css"/>
    <link rel="stylesheet" href="/css/contactUs.css"/>

    
    <link rel="stylesheet" href="/css/menu_cornermorph.css" />

    <title>Neka Beauty</title>
    <script src="/js/src/sweetalert2.8.js"></script>
</head>

<body>
    

    <?php
    require_once('svgHead.php');
    ?>

    <div class="title">
        <h2>درباره ی ما</h2>
    </div>



    <div class="desc">
        <div>
            فروشگاه نکا بیوتی به عنوان اولین فروشگاه اینترنتی تخصصی لوازم آرایشی در نکا آماده ی خدمت رسانی به همه ی همشهریان عزیز می باشد
        </div>
		<div>
			هر زمانی که مشکلی در وب سایت مشاهده کردید یا انتقاد و یا پیشنهادی دارید می توانید با شماره ی 09381308994 تماس بگیرید
        </div>
    </div>

    <div class="desc">

        <div class="row">
			<div> : مدیر وب سایت</div>
			<div>سجاد عبداللهی <i class="fas fa-user"></i></div>
        </div>
	
        <div class="row">
			<div> : پشتیبانی</div>
			<div>09381308994 <i class="fas fa-phone"></i></div>
        </div>
        
		
		<div class="row">
			<div> : ایمیل</div>
			<div>nekabeauty.com@gmail.com <i class="fas fa-envelope"></i></div>
		</div>

		
    </div>
    
    <div class="BackToHome" >
        <a href="../../home/"><i class="fas fa-home"></i></a>
    </div>
    
	
    <div class="sizeBox"></div>
    

    <?php
        require_once('svgFooterWithOutZarinpal.php');
    ?>

    
    <?php
        require_once('menuWrap.php');
    ?>

    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>

    
    <script src="/js/src/classie_morph.js"></script>
    <script src="/js/src/main_morph.js"></script>



</body>

</html>