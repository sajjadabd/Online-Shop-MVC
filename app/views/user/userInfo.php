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
	
	<link rel="stylesheet" href="/css/radioButton.css" />
	
	<script src="/js/src/cookiesHandler.js"></script>

    <title>Neka Beauty</title>
</head>



<body>

	<?php
	require_once('svgHead.php');
	?>

	<div style="display:none;" id="selectListOfProvinces"></div>

	<div style="display:none;" id="selectListOfCities"></div>

	<div style="display:none;" id="maskForSelect"></div>


    <div id="mainContent" class="content">
		
		<div class="containerTitleWrapper">
			<div class="containerTitle">
				اطلاعات شما
			</div>
		</div>
		

		<div class="userSettingForm">
			<div>
				<div class="fontFarsi">نام کاربری :</div>
				<input type="text" name="username" autocomplete="off" />
			</div>
			<div>
				<div class="fontFarsi">استان :</div>
				
				<div class="thisIsSelect" id="listOfProvinces">
					<div id="user_selected_province" name="province">

					</div>
					<div style="display:none;" id="listOfAllProvinces">

					</div>
					<!-- <option>مازندران</option> -->
				</div>
				
			</div>
			<div>
				<div class="fontFarsi">شهرستان :</div>
				
				<div class="thisIsSelect" id="listOfCities">
					<div id="user_selected_city" name="city">
						
					</div>
					<div style="display:none;" id="listOfAllCities">

					</div>

					<!-- <option>نکا</option> -->
				</div>
				
			</div>
			<div>
				<div class="fontFarsi">منطقه :</div>
				<div>
					<label class="container">شهری
						<input type="radio" id="live_in_city" name="radio">
						<span class="checkmark"></span>
					</label>
					
					<label class="container">روستایی
						<input type="radio" id="live_in_rural" name="radio">
						<span class="checkmark"></span>
					</label>
				</div>
			</div>

			<div>
				<div class="fontFarsi">کد پستی :</div>
				<input type="text" name="zipcode" autocomplete="off"/>
			</div>
			<div>
				<div class="fontFarsi">آدرس :</div>
				<textarea name="address" autocomplete="off"></textarea>
			</div>
			<div>
				<div></div>
				<button style="display:none;" id="updateUser" class="special">ثبت اطلاعات</button>
				<span class="loadingbar">
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
				</span>
			</div>
			
		</div>
		
		
		
		<!---->
		

    </div>
	
	<div class="footer">

	</div>
	
	<?php
		if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
    		require_once('menu.php');
    ?>



    <div id="sideNavModal" class="modalForSideNav">

    </div>

	
	<div id="snackbar2" class="snackbar">
		اطلاعات شما با موفقیت ثبت شد
    </div>

	<div id="snackbar3" class="snackbar">
		خطا در ثبت اطلاعات
    </div>


    
	<script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/user/index_jquery.js"></script>
	<script src="/js/user/userInfo.js"></script>

    <?php
        if(isset($_SESSION['phone']) && isset($_SESSION['sms']))
        require_once('menuScript.php');
    ?>
    
</body>

</html>