<?php
require_once('connect.php');
require_once('functions.php');
require_once('jdatetime.php');

//echo print_r($_POST);
//exit();

require_once('checkBlocked.php');

if( isset($_POST['sms']) && isset($_POST['phone']) ) {
    
	if( empty( $_POST['phone'] ) || empty($_POST['sms']) ) {
        echo json_encode(array('success'=>false,'empty'=>true));
		exit();
	}
	
	$result['success'] = false;//set $result['success'] to false
	
	$phone   = convert2english($_POST['phone']);
    $sms     = convert2english($_POST['sms']);
    
    $phone   = phoneSanitize($phone);
    $sms     = myFirstSanitize($sms);

    //echo json_encode(array('phone'=>$phone,'sms'=>$sms));
    //exit();


    $result['phone'] = $phone;
    $result['sms']   = $sms;

    if( $phone === false || $sms === false ){
        echo json_encode(array( 'success' => false , 'sanitize'=>false));
        exit();
    }


    $searchForUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $searchForUser);
    $row_count = mysqli_num_rows($res);

    $resultArray = array();

    if( $res == false ) {
        // Error On Search User
        //$result['user_search_error'] = true;
    } else {
        //$result['user_search_error'] = false;

        if( $row_count > 0 ) { // User Already Exist
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $setAttackZero = "UPDATE blocked SET hacker_attack='0' WHERE ip_address='$ip_address'";
            //$setAttackZero = "DELETE FROM blocked WHERE ip_address='$ip_address'";
            $setAttackZeroRes = mysqli_query($con, $setAttackZero);

            $result['user_existance'] = true;

            while( $row = mysqli_fetch_array($res) ) {
                $result['query'] = $row;
            }
			

            $loginUser = "UPDATE users SET activation='1' WHERE phone='$phone' AND sms='$sms'";

            $check = mysqli_query($con , $loginUser);

            if( $check == false ) {
                $result['user_activation_error'] = true;
            } else {
                $result['user_activation'] = true;
                $result['success'] = true;

                $_SESSION['phone'] = $phone;
                $_SESSION['sms'] = $sms;

                //setcookie("phone", $phone, time() + (86400 * 30), "/");
                //setcookie("sms", $sms, time() + (86400 * 30), "/");

            }
        } else { // Hacker Want To Login Some Other Account
            $result['hacker_attack'] = true;

            require_once('hacker_scanner.php');

			$result['success'] = false;

        }
    }
}
else if( isset($_POST['phone'])  && empty($_POST['sms']) ) { 

    $result['success'] = false;//set $result['success'] to false
	
	if(empty($_POST['phone'])) {
        echo json_encode(array('success'=>false,'secondEmpty'=>true));
		exit();
    }
    
    if( trim($_POST['phone'])  == '' ) {
        echo json_encode(array('success'=>false,'trim'=>true));
		exit();
    }
    
	
	$phone   = convert2english($_POST['phone']);
	
    $phone = phoneSanitize($phone);
    $result['phone'] = $phone;


    if($phone == false){
        echo json_encode(array('success'=>false,'secondSanitize'=>false,'phone'=>$phone));
		exit();
    }

    require_once('hacker_scanner.php');

    $searchForUser = "SELECT * FROM users WHERE phone='$phone' LIMIT 1";
    $res = mysqli_query($con , $searchForUser);

    $resultArray = array();

    if( $res == false ) {
        // Error On Search User
        //$result['user_search_error'] = true;
    } else {
        //$result['user_search_error'] = false;

        $randomNumber = mt_rand(10000,100000);
        //The mt_rand() function produces a better random value, and is 4 times faster than rand()

        //$result['randomNumber'] = $randomNumber;
		$row_count = mysqli_num_rows($res);
        if( $row_count > 0 ) { // User Already Exist
            //$result['user_existance'] = true;

            while( $row = mysqli_fetch_array($res) ) {
                $resultArray[] = $row;
            }

            $loginUser = "UPDATE users SET sms='$randomNumber' WHERE phone='$phone'";

            $check = mysqli_query($con , $loginUser);

            if( $check == false ) {
                //$result['refresh_sms'] = true;
            } else {
                //$result['refresh_sms'] = true;
                $result['success'] = true;
                //Here We Send $sms to $phone
				send_sms13671($phone,$randomNumber);
				
				//if($checkSmsSending === false){
				//    send_sms($phone,$randomNumber);
				//}
            }

            
        } else { // User Must Signed Up, User Not Exist In The Database
            //$result['user_existance'] = false;
			
			$ip_address = $_SERVER['REMOTE_ADDR'];
			//$date_now = date("Y/m/d");//never put h:i:sa here!! This Cause Error!
			date_default_timezone_set('Asia/Tehran');
			//$dateNow = date("Y-m-d h:i:sa");
			$dateNow = jDateTime::date('l j F Y H:i');
			//echo json_encode(array('date'=>$dateNow));
			//exit();
			
			$activation = '0';
			$province = 'مازندران';
            $city = 'نکا';
            $zero = 0;
            $live_in_city = 1;
			# $ip_address = $_SERVER['REMOTE_ADDR']
			# $date_now = now() --> this is MySQL function
            $signUpUser = "INSERT INTO users (phone , sms , province, city,live_in_city, activation, ip_address, register_date, number_of_shopping , star_rating) 
            VALUES 
			('$phone' , '$randomNumber' , '$province', '$city','$live_in_city', '$activation' , '$ip_address' , '$dateNow' , '$zero' , '$zero')";

            $check = mysqli_query($con , $signUpUser);

            if( $check == false ) {
                $result['user_signUp_error'] = true;
            } else {
                //$result['user_signUp'] = true;
                $result['success'] = true;
                //Here We Send $sms to $phone
				send_sms13671($phone,$randomNumber);
				
				//if($checkSmsSending === false){
				//    send_sms($phone,$randomNumber);
				//}
            }
        }
    }
} else {
    $result['success'] = false;
}


echo json_encode($result);

?>