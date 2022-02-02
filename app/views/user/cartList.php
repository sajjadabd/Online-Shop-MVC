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

	<link rel="stylesheet" href="/css/finishMessage.css" />
	
	<script src="/js/src/cookiesHandler.js"></script>

    <title>Neka Beauty</title>
</head>



<body>
    

	<?php
	require_once('svgHead.php');
	?>

	<div style="display:none;" class="sizeBox">
	</div> 

    <div id="mainContent" class="content">
		
		<div class="containerTitleWrapper">
			<div class="containerTitle">
			لیست خریدهای شما
			</div>
		</div>
		
		<div id="listOfBaskets">

			
			<div id="listOfBasketsContent">

			</div>

        </div>
        

		
		<!---->
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

	

    <div id="sideNavModal" class="modalForSideNav">

	</div>
	
	<?php
	if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menu.php');
    ?>


    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/index_jquery.js"></script>
	<script src="/js/user/cartList.js"></script>
	<script src="/js/src/printThis.js"></script>
	<script src="/js/user/printThisCode.js"></script>

    <?php
        if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menuScript.php');
    ?>
    
</body>

</html>