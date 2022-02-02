<?php

function arabicToPersian($string)
{
	$characters = [
		'ك' => 'ک',
		'دِ' => 'د',
		'بِ' => 'ب',
		'زِ' => 'ز',
		'ذِ' => 'ذ',
		'شِ' => 'ش',
		'سِ' => 'س',
		'ى' => 'ی',
		'ي' => 'ی',
		'١' => '۱',
		'٢' => '۲',
		'٣' => '۳',
		'٤' => '۴',
		'٥' => '۵',
		'٦' => '۶',
		'٧' => '۷',
		'٨' => '۸',
		'٩' => '۹',
		'٠' => '۰',
	];
	return str_replace(array_keys($characters), array_values($characters),$string);
}

function convert($string) {
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

    return $englishNumbersOnly;
}

function convert2english($string) {
    $newNumbers = range(0, 9);
    // 1. Persian HTML decimal
    $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
    // 2. Arabic HTML decimal
    $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
    // 3. Arabic Numeric
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    // 4. Persian Numeric
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

    $string =  str_replace($persianDecimal, $newNumbers, $string);
    $string =  str_replace($arabicDecimal, $newNumbers, $string);
    $string =  str_replace($arabic, $newNumbers, $string);
	$string =  str_replace($persian, $newNumbers, $string);
	return $string;
}




//15321
//send to user when user buy a basket
function send_sms15321($phone,$price){
	try {
                                        
		date_default_timezone_set("Asia/Tehran");
		
		include_once("Classes/UltraFastSend.php");

		// your sms.ir panel configuration
		$APIKey    = "e08d36eeb9dd57e2b97b36ee";
		$SecretKey = "^!4tB*9|-m@*7";
		
		// message data
		$data = array(
			"ParameterArray" => array(
				array(
					"Parameter" => "phone",
					"ParameterValue" => $phone,
				),
				array(
					"Parameter" => "price",
					"ParameterValue" => $price,
				),
			),
			"Mobile" => $phone,
			"TemplateId" => "15321"
		);

		$SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
		$UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
		//var_dump($UltraFastSend);
		
	} catch (Exeption $e) {
		//echo 'Error UltraFastSend : '.$e->getMessage();
		//return false;
	}
}



//14841
//send to admin when user buy a basket
function send_sms14841($admin_phone,$phone,$price){
	try {
		
		date_default_timezone_set("Asia/Tehran");
		
		include_once("Classes/UltraFastSend.php");

		// your sms.ir panel configuration
		$APIKey    = "e08d36eeb9dd57e2b97b36ee";
		$SecretKey = "^!4tB*9|-m@*7";
		
		// message data
		$data = array(
			"ParameterArray" => array(
				array(
					"Parameter" => "phone",
					"ParameterValue" => $phone
				),
				array(
					"Parameter" => "price",
					"ParameterValue" => $price
				),
			),
			"Mobile" => $admin_phone,
			"TemplateId" => "14841"
		);

		$SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
		$UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
		//var_dump($UltraFastSend);
		
	} catch (Exeption $e) {
		//echo 'Error UltraFastSend : '.$e->getMessage();
		//return false;
	}
}



function passwordHashing($password)
{
	for($i=0;$i<2;$i+=1)
	{
		$password = md5($password);
	}
	for($i=0;$i<5;$i+=1)
	{
		$password = sha1($password);
	}
	return $password;
}

function phoneSanitize($phone){
	$phone = myFirstSanitize($phone);
	if(preg_match("/[0-9]{4}[0-9]{3}[0-9]{4}/", $phone)) {
		// $phone is valid
		return $phone;
	} else {
		return false;
	}
}

function myFirstSanitize($data)
{
    //$data = convert($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	if(is_numeric($data) == false){
		return false;
	}

	return $data;
}


function myStringSanitize($data)
{
    //$data = arabicToPersian($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


?>