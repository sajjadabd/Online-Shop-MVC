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
            <table class="table orders">
                <thead>
                    <th>order_id</th>
                    <th>product_id</th>
                    <th>user_id</th>
                    <th>multiply</th>
                    <th>activation</th>
                    <th>basket_id</th>
                </thead>
                <tbody id="orders_tbody">

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
                <span class="close-delete-item">&times;</span>
                <!-- <h2>فروشگاه نکا بیوتی</h2> -->
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

	<script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/admin/watchOrders.js"></script>
    <script src="/js/admin/logoff.js"></script>
	

</body>

</html>