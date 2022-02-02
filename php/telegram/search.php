<?php
//require_once('../connect.php');
//require_once('../functions.php');

$token = '720561721:AAFyzli3mQw3XohRsWsp4ti2YCbK9oa7mHQ';
$telegram = "https://api.telegram.org/bot$token";

$opts = array(
        'https'=>array(
            'method' => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata,
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'timeout' => 5
        ),
        'ssl'=>array(
            'method' => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata,
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'timeout' => 5
        ),
    );

$context = stream_context_create($opts);

$input = file_get_contents("php://input", false, $context);
//$input = stream_context_create("php://input", ['verify_peer' => false]);
//$input = $_POST;

$inputArray = json_decode($input , true);

$length = count($inputArray['result']);
//$length = 1;


$chat_id = $inputArray['result'][$length-1]['message']['chat']['id'];
$first_name = $inputArray['result'][$length-1]['message']['chat']['username'];
$is_bot = $inputArray['result'][$length-1]['message']['from']['is_bot'];
$searchTerm = $inputArray['result'][$length-1]['message']['text'];

if($is_bot === true){
    exit();
}

//$chat_id = 255993989;
//$text = 'Hi Everyone';

$params = [
    'chat_id' => $chat_id,
    'text' => $searchTerm
];

$feedback = "$telegram/sendMessage?".http_build_query($params);
//stream_context_create($telegram.'/sendMessage?chat_id='.$chat_id.'&text='.$searchTerm, ['verify_peer' => false]);
file_get_contents($feedback , false , $context);
//echo json_encode(array('nekabeauty'=>true));
exit();
?>