<?php
require_once('connect.php');
require_once('functions.php');
require_once('jdatetime.php');



if( isset($_POST['phone']) && isset($_POST['sms']) ){

    $phone = myFirstSanitize($_POST['phone']);
    $sms   = myFirstSanitize($_POST['sms']);
    
    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms'";
    $res = mysqli_query($con , $checkUser);
    
    if( $res == false ){
        // Error On Selecting User
    } else {

        while( $row = mysqli_fetch_array($res) ) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $city = $row['city'];
            $province = $row['province'];
            $live_in_city = $row['live_in_city'];
        }
		
		$calculatePrice = "SELECT orders.*, products.price, products.stock FROM orders 
		LEFT JOIN products ON orders.product_id=products.product_id
        WHERE orders.user_id='$user_id' AND orders.activation='0'";
        
		$res = mysqli_query($con , $calculatePrice);
		
		$priceTemp = 0;
		$mul = 0;
		$price = 0;
		
		if($res === false){
		
		} else {
			while( $row = mysqli_fetch_array($res) ) {
				$priceTemp = $row['price'];
                $mul = $row['multiply'];

				$price += ($priceTemp * $mul);
			}
        }


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


        $live_in_city = (int)$live_in_city;
        if($live_in_city === 1){

        } else {
            $basket_post_price = $rural_basket_post_price;
        }

        $price += $basket_post_price;
        
        /*
        echo json_encode(array(
            'price'=>$price,
            'basket_post_price'=>$basket_post_price
            ));
        exit();
        */

        //https://www.nekabeauty.com/home/PaymentCallBack
        $data = array(
        'MerchantID' => '32a9c2f6-c7d0-11e9-b9dc-000c295eb8fc',
        'Description' => 'نکا بیوتی',
        'Amount' => $price,
        'CallbackURL' => 'https://nekabeauty.com/home/PaymentCallBack',
        'Mobile' => $phone
        );

        $jsonData = json_encode($data);

        $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
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
        $result = json_decode($result, true);

        curl_close($ch);

        if ($err) {
            //echo "cURL Error #:" . $err;
        } else {
            if ($result['Status'] == 100) {
                //header('Location: https://www.zarinpal.com/pg/StartPay/' . $result["Authority"]); 
            } else {
                //echo'ERR: ' . $result["Status"];
            }
        }

        $authority = $result["Authority"];
        $success = 0;
        
        /*
        echo json_encode(array(
            'user_id'=>$user_id,
            'authority'=>$authority,
            'price'=>$price,
            'success'=>$success,
            ));
        exit();
        */

        $insertPayment = "INSERT INTO payments (user_id,username,phone,authority,price,success) VALUES ('$user_id','$username','$phone','$authority','$price','$success')";
        $insertPaymentResult = mysqli_query($con, $insertPayment);
        
        if($insertPaymentResult === false){
            echo json_encode(array(
                'success'=>false,
            ));
            exit();
        } else {
            echo json_encode(array(
                'success'=>true,
                'price'=>$price,
                'Authority'=>$result['Authority'],
                'status'=>$result['Status'],
                'url'=>'https://www.zarinpal.com/pg/StartPay/'.$result['Authority'].'/ZarinGate'
            ));
            exit();
        }
    }
} else {
    echo json_encode(array('success'=>false));
    exit();
}

?>