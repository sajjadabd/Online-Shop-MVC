<?php

$ip_address = $_SERVER['REMOTE_ADDR'];

require_once('calculateMinutes.php');

$selectAttack = "SELECT * FROM adminattack WHERE ip_address='$ip_address' LIMIT 1";
$selectAttackRes = mysqli_query($con , $selectAttack);

if($selectAttackRes === false){

} else {
    $attack_before = mysqli_num_rows($selectAttackRes);

    if($attack_before > 0) {
        while($getAttack = mysqli_fetch_array($selectAttackRes)){
            $hacker_attack = $getAttack['hacker_attack'];
            $from_date = $getAttack['date'];
        }

        if($hacker_attack >= 5){

            $from_date = strtotime($from_date);
            $to_date = date("Y-m-d h:i:sa");
            $to_date = strtotime($to_date);

            $diff = calculateMinutes($from_date,$to_date);
            $minutes = $diff;
            $minutes = 60-$minutes;

            if($minutes <= 60 && $minutes > 0) {
                echo json_encode(array('block'=>true,'min'=>$minutes));
                exit();
            } else {
                $setAttackZero = "UPDATE adminattack SET hacker_attack='0',date='$to_date' WHERE ip_address='$ip_address'";
                //$setAttackZero = "DELETE FROM blocked WHERE ip_address='$ip_address'";
                $setAttackZeroRes = mysqli_query($con, $setAttackZero);
            }

        } else {

        }
    } else {

    }
}


?>