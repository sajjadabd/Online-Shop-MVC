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
	
	
    <link rel="stylesheet" href="/css/questions.css" />

    
    <link rel="stylesheet" href="/css/menu_cornermorph.css" />
    
    
    <?php
        require_once("css/cssGlobal.php");
        require_once("css/cssUserLogin.php");
    ?>
    

    <title>Neka Beauty</title>
    <script src="/js/src/sweetalert2.8.js"></script>
</head>

<body>
    

    <?php
    require_once('svgHead.php');
    ?>

    <div class="title">
        <h2>سوالات متداول در نکا بیوتی</h2>
    </div>

    <div class="content">
        <div class="questions">       
    
            <dl>
                
            <dt>فروشگاه نکا بیوتی در چه شهرستان هایی فعالیت می کند ؟</dt>
            <dd>فعلاً شهرستان نکا</dd>
    
            <dt>چه مدت زمان طول می کشد تا خرید به دستم برسد ؟</dt>
            <dd> کمتر از 1 روز </dd>
    
            <dt>کالاهای ثبت شده در سبد خرید تا چه زمانی باقی می مانند ؟</dt>
            <dd>تا زمانی که موجودی هر محصول بیشتر از درخواست شما باشد</dd>
    
            <!--<dt>سوال؟</dt>
            <dd>جواب</dd>-->
    
            </dl>
            
        </div>
    </div>
    
    

    <!--<div class="sizeBox"></div>-->
    

    
    
    <div class="BackToHome" >
        <a href="../../home/"><i class="fas fa-home"></i></a>
    </div>
    

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