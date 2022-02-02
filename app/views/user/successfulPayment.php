<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
        require_once("css/cssGlobal.php");
    ?>
    <link rel="stylesheet" href="/css/paymentCallback.css" />
    <title>Neka Beauty</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div>خرید شما با موفقیت انجام شد</div>
            <div>
                <div> کد رهگیری </div>
                <div><?php echo $Authority; ?></div>
            </div>
            <div>
                <a href="https://nekabeauty.com/home/shop/">بازگشت به فروشگاه نکا بیوتی</a>
            </div>
        </div>
    </div>
</body>
</html>