<?php
session_start();
require_once('connect.php');
require_once('functions.php');
require_once('jdatetime.php');


if (isset($_GET['Status'])) {
    
} else {
    require_once('error404.php');
    exit();
}

$status = $_GET['Status'];

if( $status == 'OK') {
    
    $Amount = 0; //Amount will be based on Toman
    $Authority = $_GET['Authority'];
    

    $getAmount = "SELECT * FROM payments WHERE authority='$Authority' LIMIT 1";
    $res = mysqli_query($con , $getAmount);

    if($res === false){

    } else {
        while($row = mysqli_fetch_array($res)){
            $Amount = $row['price'];
        }
    }
    
    //$Amount = 1000;
    
    $data = array(
        'MerchantID' => '32a9c2f6-c7d0-11e9-b9dc-000c295eb8fc', 
        'Authority' => $Authority, 
        'Amount' => $Amount
    );
    
    $jsonData = json_encode($data);
    $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
    ));

    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    $result = json_decode($result, true);

    if ($err) {
        //echo "cURL Error #:" . $err;
    } else {
        if ($result['Status'] == 100 || $result['Status'] == 101) {
            //echo json_encode($result);
            //exit();
            //echo 'Transation success. RefID:' . $result['RefID'];
            
            $checkPayment = "SELECT * FROM payments WHERE authority='$Authority' AND success='1'";
            $checkPaymentResult = mysqli_query($con , $checkPayment);
            
            if($checkPaymentResult === false){
                //echo 'here 0';
            } else {
                $count_payment = mysqli_num_rows($checkPaymentResult);
                if($count_payment > 0){
                    //echo 'here 1';
                    // we do all the stuff before
                    // we never want to repeat it (basket duplicate)!!!
                    $refID = $result["RefID"];
                    Header("Location: https://www.nekabeauty.com/home/successfulPayment/$refID/");
                    exit();
                } else {

                    $refID = $result["RefID"];
                    //echo 'here 2';
                    $successfulPayment = "UPDATE payments SET success='1' WHERE authority='$Authority'";
                    $res = mysqli_query($con , $successfulPayment);
                    
                    if($res === false){
                        
                    } else {
                        
                        $selectUser = "SELECT * FROM payments WHERE authority='$Authority' AND success='1'";
                        $selectUserResult = mysqli_query($con ,$selectUser);
        
                        if($selectUserResult === false){
        
                        } else {
                            $count_user = mysqli_num_rows($selectUserResult);
                            if($count_user > 0){
        
                                while($row = mysqli_fetch_array($selectUserResult)){
                                    $user_id = $row['user_id'];
                                }
                                
                                
                                //$user_id = (int)$user_id;
        
                                $userPick = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
                                $userPickResult = mysqli_query($con, $userPick);
        
                                if($userPickResult === false){
                                    //echo 'here 5';
                                    //exit();
                                } else {
                                    
                                    while($row = mysqli_fetch_array($userPickResult)) {
                                        $phone = $row['phone'];
                                        $username = $row['username'];
                                        $city = $row['city'];
                                        $province = $row['province'];
                                        $liveInCity = $row['live_in_city'];
                                        $number_of_shopping = $row['number_of_shopping'];
                                    }
                                    
                                    /*
                                    echo json_encode(array(
                                        'user_id'=>$user_id,
                                        'phone'=>$phone,
                                        'city'=>$city,
                                        'province'=>$province,
                                        'liveInCity'=>$liveInCity,
                                        'number_of_shopping'=>$number_of_shopping,
                                        ));
                                    exit();
                                    */
                                
                                    $number_of_shopping = (int) $number_of_shopping;
                                    $number_of_shopping += 1;
                                    
                                    $increase_number_of_shopping = "UPDATE users SET number_of_shopping='$number_of_shopping' WHERE user_id='$user_id'";
                                    $increaseShoppingNumber = mysqli_query($con , $increase_number_of_shopping);
                                    
                                    $calculatePrice = "SELECT orders.*, products.price, products.stock FROM orders 
                                    LEFT JOIN products ON orders.product_id=products.product_id
                                    WHERE orders.user_id='$user_id' AND orders.activation='0'";
                                    
                                    $res = mysqli_query($con , $calculatePrice);
                                    
                                    $priceTemp = 0;
                                    $mul = 0;
                                    $price = 0;
                                    
                                    if($res === false){
                                    
                                    } else {
                                        while( $row = mysqli_fetch_array($res) )
                                        {
                                            $priceTemp = $row['price'];
                                            $mul = $row['multiply'];
                                            $product_id = $row['product_id'];
                                            $stock = $row['stock'];
        
                                            $finalStock = $stock - $mul;
        
                                            $decreaseStock = "UPDATE products SET stock='$finalStock' WHERE product_id='$product_id'";
                                            $decreaseStockResult = mysqli_query($con , $decreaseStock);

                                            $deleteSomeOrders = "DELETE FROM orders WHERE product_id='$product_id' AND multiply>'$stock' AND activation='0'";
                                            $deleteSomeOrdersRes = mysqli_query($con, $deleteSomeOrders);
        
                                            $price += ($priceTemp * $mul);
                                        }
                                    }
                                    
                                    //$uniq_id = uniqid();
                                    $fetchPostPrice = "SELECT * FROM cities WHERE city_name='$city' AND province_name='$province' LIMIT 1";
                                    $postPriceResult = mysqli_query($con, $fetchPostPrice);

                                    if($postPriceResult === false){

                                    } else {
                                        $count_city = mysqli_num_rows($postPriceResult);
                                        if($count_city > 0){
                                            while($row = mysqli_fetch_array($postPriceResult)){
                                                $basket_post_price = $row['post_price'];
                                                $rural_basket_post_price = $row['rural_post_price'];
                                            }
                                        }
                                    }


                                    $liveInCity = (int)$liveInCity;
                                    if($liveInCity === 1){

                                    } else if($liveInCity === 0){
                                        $basket_post_price = $rural_basket_post_price;
                                    }
                                    
                                    /*
                                    echo json_encode(array(
                                        'price'=>$price,
                                        'basket_post_price'=>$basket_post_price,
                                        'liveInCity'=>$liveInCity,
                                        ));
                                    exit();
                                    */

                                    //$price += $basket_post_price;

                                    
                                    date_default_timezone_set('Asia/Tehran');
                                    
                                    $dateNow = jDateTime::date('l j F Y H:i');
                                    
                                    $process = 0;
                                    $payment_check = 1;
                                    $customer_regret = 0;
                                    
                                    $basket_number = mt_rand(10000,100000);
        
                                    $insertBasket = "INSERT INTO baskets (user_id, basket_number, username, phone, basket_price, basket_post_price, process ,payment_check, customer_regret, refID, authority, date) 
                                    VALUES ('$user_id', '$basket_number','$username', '$phone', '$price', '$basket_post_price', '$process' , '$payment_check' , '$customer_regret' ,'$refID' , '$Authority' , '$dateNow')";
                                    
                                    $res = mysqli_query($con, $insertBasket);

                                    if($res === false){

                                    } else {
                                        $basket_id = mysqli_insert_id($con);


                                        $updateAllOrders = "UPDATE orders SET activation='1', basket_id='$basket_id' WHERE user_id='$user_id' AND activation='0'";
                                        $res = mysqli_query($con, $updateAllOrders);
                                        
                                        /*
                                        echo json_encode(array(
                                            'phone'=>$phone,
                                            'amount'=>$Amount,
                                            ));
                                        exit();
                                        */
                                        
                
                                        // --- SEND SMS TO USER WHEN USER PAY THE BASKET ----
                                        $admin_phone_number = "09381308994";
                                        send_sms14841($admin_phone_number,$phone,$Amount);
                                        // ---------------------------------------------------
    
                                        // --- SEND SMS TO USER WHEN USER PAY THE BASKET ----
                                        //send_sms15321($phone,$Amount);
                                        send_sms15321($phone,$Amount);
                                    }
                                }
                            } else {
        
                            }
                        }
                        
                        
                        
                        $refID = $result["RefID"];
                        Header("Location: https://www.nekabeauty.com/home/successfulPayment/$refID/");
                        
                        exit();
                    }
                }
            }
   
        } else {
            //echo 'Transation failed. Status:' . $result['Status'];
            require_once('badPayment.php');
            exit();
        }
    }	
} else if( $status == 'NOK') {
    //echo 'Transaction canceled by user';
    //require_once('error404.php');
    //echo '_GET Not Set';
    //echo $_GET['Authority'];
    //echo '<br />';
    //echo $_GET['Status'];
    require_once('badPayment.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Neka Beauty</title>
</head>
<body>


</body>
</html>