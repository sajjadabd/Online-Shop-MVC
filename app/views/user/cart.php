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
        require_once("css/cssUserGlobal.php");
    ?>
       
    <link rel="stylesheet" href="/css/swiper.css" />
    <link rel="stylesheet" href="/css/finishMessage.css" />
    <link rel="stylesheet" href="/css/cart.css" />
    
    <script src="/js/src/sweetalert2.8.js"></script>
    <link href="/css/aos.css" rel="stylesheet">
	<script src="/js/src/cookiesHandler.js"></script>

    <title>Neka Beauty</title>
</head>



<body>

    <?php
    require_once('svgHead.php');
    ?>

<!-- 
    <div class="sizeBox">

    </div> -->


    <div id="mainContent" class="content">
        
        <div class="containerTitleWrapper">
            <div class="containerTitle">
                سبد خرید
            </div>
        </div>
        
        <div id="MyBasket">
        <!-- style="display:none;" -->
            <div style="display:none;" id="SubmitBasketInfo" class="SubmitBasket">
                <button id="SubmitBasketButton" class="special">تایید خرید</button>
                <div style="display:none;" id="loading2" class="loadingContainer">
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
                <div class="postInfo">
                    <!-- <div>هزینه بسته بندی : رایگان</div>
                    <div>هزینه ارسال : 2000 تومان</div> -->
                    <table>
                        <thead>
                            <tr>
                                <th class="first"> کالا و برند </th>
                                <th class="second">تعداد</th>
                                <th class="third">قیمت واحد</th>
                                <th class="fourth">قیمت کل</th>
                            </tr>
                        </thead>
                        <tbody id="factor_table">

                        </tbody>
                    </table>
                </div>
            </div>
            

            <div id="MyBasketContent">

            </div>
            
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
	
	<div class="footer">

    </div>
	
	
	<!-- The Modal For Delete Item -->
    <div id="myModal-delete-item" class="modal-delete-item">
        <!-- Modal content -->
        <div class="modal-content-delete-item">

            <div class="modal-header-delete-item">
                <span class="close-delete-item">&times;</span>
            </div>
            
            <div class="modal-body-delete-item">
                <p>آیا برای حذف این کالا از سبد خرید اطمینان دارید؟</p>
                <p></p>
            </div>
            <div class="modal-footer-delete-item">
                <button id="deleteItemButton" class="special">بله</button>
            </div>
        </div>
    </div>

    <div id="sideNavModal" class="modalForSideNav">

    </div>

    <?php
    if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menu.php');
    ?>

	
	<div id="snackbar3" class="snackbar">
		خرید شما با موفقیت انجام شد
    </div>

    <div id="snackbar2" class="snackbar">
        بیشتر از موجودی نمیتوانید خرید کنید
    </div>

    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/index_jquery.js"></script>
    <script src="/js/user/cart.js"></script>

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