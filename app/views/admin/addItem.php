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

    <link rel="stylesheet" href="/css/adminLoadingBar.css" />

    <title>Neka Beauty</title>
</head>

<body>

    <?php
    require_once('header.php');
    ?>


    <div id="adminContent" class="adminContent">



        <div id="form" class="selectTab">
            <!-- product_id , title , brand , category , picture , price -->
            <div class="left">
                <span>Title : </span>
                <div>
                    <input name="title" type="text" autocomplete="off" />
                </div>

                <span>Brand :</span>
                <div>
                    <input name="brand" type="text" autocomplete="off" />
                </div>

                <span>Description :</span>
                <div>
                    <input name="description" type="text" autocomplete="off" />
                </div>
				
				<span>Stock :</span>
                <div>
                    <input name="stock" type="text" autocomplete="off" />
                </div>

                <span>Category :</span>
                <div>
                    <select name="category" id="selectInsertProduct">
                        <!-- <option>رژ لب</option> -->
                    </select>
                </div>

                <span>Price :</span>
                <div>
                    <input name="price" type="text" autocomplete="off" />
                </div>

                <span>Color :</span>
                <div>
                    <input name="color" type="text" autocomplete="off" />
                </div>


                <label class="checkboxcontainer">Original
                    <input type="checkbox" value="1" name="original">
                    <span class="checkmark"></span>
                </label>

            </div>

            <div class="right">
                <span>Picture :</span>
                <div id="file" name="picture" class="file">
                    Drag Items Here
                </div>
                <div>
                    <button id="addItemButton" class="normalButton">Add Item</button>
                </div>
                <div class="progressbar">
                    <div class="greenbar"></div>
                </div>
                <div class="progressbarText"></div>
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
	
	<script src="/js/src/cookiesHandler.js"></script>
	<script src="/jQueryCDN/jquery-3.4.1.min.js"></script>
    <script src="/js/admin/addItem.js"></script>
	<script src="/js/admin/logoff.js"></script>

</body>

</html>