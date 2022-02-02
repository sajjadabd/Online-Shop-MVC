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


    <link rel="stylesheet" href="/css/sliceBox/style.css" />
    <link rel="stylesheet" href="/css/swiper.css" />
    <link rel="stylesheet" href="/css/products.css" />

    
    <link rel="stylesheet" href="/css/menu_cornermorph.css" />

	<script src="/js/src/cookiesHandler.js"></script>

    <title>Neka Beauty</title>
</head>

<body>

    <?php
        require_once('svgHead.php');
    ?>

    <div id="mainContent" class="content">

		
		<div style="visibility:hidden;" id="product">
            <?php
            echo $product_id;
            ?>
        </div>
		

        <div id="product_result">

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

    <div class="BackToHome" >
        <a href="../../../home/"><i class="fas fa-home"></i></a>
    </div>

    <?php
        //require_once('menuWrap.php');
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
    <script src="/js/user/product.js"></script>
    <script src="/js/src/swiper.js"></script>

    
    <script src="/js/src/classie_morph.js"></script>
    <script src="/js/src/main_morph.js"></script>
    
</body>

</html>