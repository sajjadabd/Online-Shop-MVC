<?php
session_start();
require_once('url_checker.php');
require_once('checkAdmin.php');

?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    
    <?php
        require_once("css/cssAdmin.php");
        require_once("css/cssGlobal.php");
    ?>
	
	<link rel="stylesheet" href="/css/addCategory.css" />
	
    <script src="/js/src/sweetalert2.8.js"></script>
	
    <title>Neka Beauty</title>
</head>


<body>
    
    
    <?php
    require_once('header.php');
    ?>


    <div id="adminContent" class="adminContent">

        <div class="addCategoryContainer container">
			<div>
				<div class="title">
					Add Category :
				</div>
				<div>
					<input type="text" id="addCategoryInput" placeholder="insert category" autocomplete="off" />
				</div>
				<div>
					<button id="addCategoryButton" class="normalButton">Submit Category</button>
				</div>
			</div>
			<div class="listCategory" id="listCategory">

			</div>
        </div>

        
		
		<div class="addProvinceContainer container">
			<div>
				<div class="title">
					Add Province :
				</div>
				<div>
					<input type="text" id="addProvinceInput" placeholder="province name" autocomplete="off" />
				</div>
				<div>
					<button id="addProvinceButton" class="normalButton">Submit Province</button>
				</div>
			</div>
			<div class="listCategory" id="listProvince">

			</div>
        </div>

		
		
		<div class="addCityContainer container">
			<div>
				<div class="title">
					Add City :
				</div>
				<div class="row">
					<select id="selectedProvince">
						<option>مازندران</option>
					</select>
					<input type="text" id="addCityInput" placeholder="city name" autocomplete="off" />
					<input type="text" id="post_price" placeholder="post price" autocomplete="off" />
					<input type="text" id="rural_post_price" placeholder="rural post price" autocomplete="off" />
				</div>
				<div>
					<button id="addCityButton" class="normalButton">Submit City</button>
				</div>
			</div>
			<div class="listCategory" id="listCity">

			</div>
        </div>



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
	

	<script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/admin/addCategory.js"></script>
	<script src="/js/admin/logoff.js"></script>

</body>

</html>