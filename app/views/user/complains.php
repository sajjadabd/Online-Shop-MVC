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
        require_once("css/cssUserGlobal.php");
    ?>
    
    <link rel="stylesheet" href="/css/laws.css"/>
	
    <link rel="stylesheet" href="/css/complains.css"/>

    
    <link rel="stylesheet" href="/css/menu_cornermorph.css" />

    <title>Neka Beauty</title>
    <script src="/js/src/sweetalert2.8.js"></script>
</head>

<body>
    

    <?php
    require_once('svgHead.php');
    ?>

	
    <div class="title">
        <h2>ثبت انتقاد</h2>
    </div>
	
	<div class="userSettingForm">
		<div>
			<div class="fontFarsi">موضوع انتقاد :</div>
			<input type="text" name="complainTopic" autocomplete="off" placeholder="موضوع انتقاد" />
		</div>
		<div>
			<div class="fontFarsi">متن انتقاد :</div>
			<textarea name="complainText" autocomplete="off" placeholder="متن انتقاد"></textarea>
		</div>
		<div>
			<div></div><button id="submitComplain" class="special">ثبت انتقاد</button>
		</div>
	</div>

    

    <!--<div class="sizeBox"></div>-->
    
    
    <div class="BackToHome" >
        <a href="../../home/"><i class="fas fa-home"></i></a>
    </div>

    <div id="snackbar" class="snackbar"> 
        <div>نظر شما با موفقیت ثبت شد</div>
    </div>


    <div id="snackbar2" class="snackbar"> 
        <div>خطا در ثبت انتقاد</div>
    </div>
    

    <?php
        require_once('svgFooterWithOutZarinpal.php')
    ?>

    <?php
        require_once('menuWrap.php');
    ?>


    <script src="/js/src/cookiesHandler.js"></script>
    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/complain.js"></script>

    
    <script src="/js/src/classie_morph.js"></script>
    <script src="/js/src/main_morph.js"></script>



</body>

</html>