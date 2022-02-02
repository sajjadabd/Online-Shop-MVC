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

    <title>Neka Beauty</title>
</head>


<body>

    <?php
    require_once('header.php');
    ?>


    <div id="adminContent" class="adminContent">

        <div class="selectTab">
			<div class="searchBoxContainer">
			<input type="text" name="productSearch" id="productSearch" 
			placeholder="Search Products On Title,Category Or Description..." class="search" autocomplete="off" />
			</div>
            <table class="table">
                <thead>
                    <th>product_id</th>
                    <th>title</th>
                    <th>category</th>
                    <th>brand</th>
                    <th>description</th>
                    <th>stock</th>
                    <th>picture</th>
                    <th>price</th>
                    <th>del?</th>
                </thead>
                <tbody id="products_tbody">

                </tbody>
            </table>
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
	
	
	<!-- The Modal For Delete Item -->
    <div id="myModal-delete-item" class="modal-delete-item">
        <!-- Modal content -->
        <div class="modal-content-delete-item">

            <div class="modal-header-delete-item">
                <span class="close close-delete-item">&times;</span>
                <!-- <h2>فروشگاه نکا بیوتی</h2> -->
            </div>
            <div class="modal-body-delete-item">
                <p>آیا برای حذف این کالا از سبد خرید اطمینان دارید؟</p>
                <p></p>
            </div>
            <div class="modal-footer-delete-item">
                <button id="deleteItemButton">بله</button>
            </div>
        </div>
    </div>

    
    <script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/admin/watchProducts.js"></script>
    <script src="/js/admin/deleteProduct.js"></script>
	<script src="/js/admin/logoff.js"></script>

</body>

</html>