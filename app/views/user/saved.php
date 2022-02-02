<?php
session_start();

require_once('url_checker.php');

require_once('checkUserLogin.php');


?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <?php
        require_once('meta_tags.php');
    ?>
    <?php
        require_once("css/cssGlobal.php");
        //require_once("css/cssUserGlobal.php");
    ?>

    <!-- <link rel="stylesheet" href="/mvc/public/css/index.css" />
    <link rel="stylesheet" href="/mvc/public/css/circle-menu.css"> -->


    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/circle-menu.css">
    <link rel="stylesheet" href="/css/swiper.css" />
    <link rel="stylesheet" href="/css/finishMessage.css" />
    <link rel="stylesheet" href="/css/saved.css" />

    
    <link href="/css/aos.css" rel="stylesheet">
	
	<script src="/js/src/cookiesHandler.js"></script>

    <title>Neka Beauty</title>
</head>



<body>

    <?php
    require_once('svgHead.php');
    ?>


    <div id="mainContent" class="content">

        <div class="containerTitleWrapper">
            <div class="containerTitle">
                کالاهای ذخیره شده
            </div>
        </div>

        <!-- <div class="topSizeBox"></div> -->

        
        <div id="savedList">
			
   
        </div>
        

		<div id="loading" class="loadingContainer">
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

    </div>

    <div class="sizeBox"></div>
	
	<div class="footer">

    </div>

    <!-- The Modal For Login -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <div class="modal-header">
                <span class="close">&times;</span>
                <!-- <h2>فروشگاه نکا بیوتی</h2> -->
            </div>
            <div class="modal-body">
                <p>برای خرید از فروشگاه نکا بیوتی باید وارد سایت شوید</p>
                <p></p>
            </div>
            <div class="modal-footer">
                <button id="entranceButton" class="special">ورود به فروشگاه</button>
            </div>
        </div>
    </div>


    
	

    <div id="sideNavModal" class="modalForSideNav">

    </div>


    <?php
    if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menu.php');
    ?>

	

    <div id="snackbar" class="snackbar">کالای انتخابی به سبد خرید اضافه شد
        <div>تعداد <span class="multiplyResult">...</span> عدد از این کالا در سبد خرید می باشد</div>
    </div>

    <div id="snackbar2" class="snackbar">
        <div>بیشتر از موجودی نمی توانید خرید کنید</div>
    </div>

    <div id="snackbar3" class="snackbar">
        <div>خطا در فرآیند ثبت خرید</div>
    </div>
    
    <script src="/js/user/modal.js"></script>
    
    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/index_jquery.js"></script>
    <script src="/js/user/saved.js"></script>
    <script src="/js/src/swiper.js"></script>

    <?php
    if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menuScript.php');
    ?>

<script src="/js/src/aos.js"></script>

<script>
AOS.init({
// Global settings:
disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
initClassName: 'aos-init', // class applied after initialization
animatedClassName: 'aos-animate', // class applied on animation
useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
disableMutationObserver: false, // disables automatic mutations' detections (advanced)
debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


// Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
offset: 120, // offset (in px) from the original trigger point
delay: 0, // values from 0 to 3000, with step 50ms
duration: 1000, // values from 0 to 3000, with step 50ms
easing: 'ease', // default easing for AOS animations
once: false, // whether animation should happen only once - while scrolling down
mirror: false, // whether elements should animate out while scrolling past them
anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

});
</script>
    
</body>

</html>


