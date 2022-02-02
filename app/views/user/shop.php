<?php
session_start();

require_once('url_checker.php');

require_once('visit_counter.php');

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
    
    <link rel="stylesheet" href="/css/menu_cornermorph.css" />
    
    <!-- <link rel="stylesheet" href="/mvc/public/css/style_swiper.css" /> -->

    <link rel="stylesheet" href="/css/backToTop.css">
    <link rel="stylesheet" href="/css/aos.css">
	

    <title>Neka Beauty - فروشگاه لوازم آرایشی نکا بیوتی</title>
</head>



<body>
    
    <?php
        require_once('svgHead.php');
    ?>
    
    <div style="display:none;" class="backToTop">
        <button id="backToTop"><i class="fas fa-angle-up"></i></button>
    </div>


    <div class="bars">
        
        <div class="searchBoxContainer">
        
            <input id="search" class="search" type="text" title="جستجو در فروشگاه لوازم آرایشی نکا بیوتی" name="search" placeholder="" autocomplete="off" />
            <i class="fas fa-search"></i>
            <div class="basket_near_search">
                <a href="../cart/" id="basket_near_search">
                    <i class="fas fa-shopping-cart checkLogin tooltipNearSearchbar">
                    <span style="display:none;" class="basketNotificationButton"></span>
                    <span class="tooltiptext">سبد خرید</span>
                    </i>
                </a>
            </div>
        </div>
        

        <div id="bars">
            <div>
                <span class="category">دسته بندی ها</span><i class="fas fa-bars category"></i>
            </div>
            <div id="categoryShow">
                همه ی محصولات
            </div>
        </div>
    </div>

    <div id="sidenav" class="sidenav">
        <ul>
            <li><a id="close" href="#"><i class="fas fa-times"></i></a></li>
            <li><a id="category_0" href="#">همه ی محصولات</a></li>

            <span id="sidenav_ul">

            </span>

        </ul>
    </div>
	
	
	<div class="title">
        <h1 title="فروشگاه لوازم آرایشی نکا بیوتی">فروشگاه لوازم آرایشی نکا بیوتی</h1>
    </div>
	
	<div class="phoneNumber">
        <p title="فروشگاه لوازم آرایشی نکا بیوتی">شماره تماس : 09381308994</p>
    </div>


    <div id="mainContent" class="content">
		
		<div id="content">

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


    <div style="visibility:hidden;" class="myCircleMenu">
        <?php
            require_once('menu.php');
        ?>  
    </div>
	
	<?php
        require_once('svgHead.php');
    ?>

    <!-- The Modal For Login -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <div class="modal-header">
                <span class="close">&times;</span>
                <!-- <h2>فروشگاه نکا بیوتی</h2> -->
            </div>
            <div class="modal-body">
                <p>
				برای خرید از فروشگاه لوازم آرایشی نکا بیوتی باید وارد سایت شوید
				</p>
				<p></p>
            </div>
            <div class="modal-footer">
                <button id="entranceButton" class="special">ورود به فروشگاه</button>
            </div>
        </div>
    </div>

   

    <?php
        require_once('svgFooter.php');
    ?>
	

    <div id="sideNavModal" class="modalForSideNav">

    </div>
    

    <div id="snackbar" class="snackbar">کالای انتخابی به سبد خرید اضافه شد
        <div>تعداد <span class="multiplyResult">...</span> عدد از این کالا در سبد خرید می باشد</div>
    </div>


    <div id="snackbar2" class="snackbar">
        <div>بیشتر از موجودی نمی توانید خرید کنید</div>
    </div>

    <div id="snackbar3" class="snackbar">
        <div>خطا در فرآیند ثبت خرید</div>
    </div>
    
    <?php
        require_once('menuWrap.php');
    ?>
    
	

    <!-- <script src="js/snackbar.js"></script> -->
    
    <script src="/js/src/cookiesHandler.js"></script>
    <script src="/js/user/index.js"></script>
    <script src="/js/user/modal.js"></script>
    
    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/index_jquery.js"></script>
    <script src="/js/user/shop.js"></script>


    <script src="/js/src/typed.js"></script>
    <script src="/js/src/typed_code.js"></script>

    <script src="/js/src/swiper.js"></script>
    
    <script src="/js/src/classie_morph.js"></script>
    <script src="/js/src/main_morph.js"></script>
    
    <script src="/js/src/aos.js"></script>
    
    <script src="/js/user/backToTop.js"></script>

    <?php
        require_once('menuScript.php');
    ?>

    

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