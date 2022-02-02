<?php

date_default_timezone_set("Asia/Tehran");

$ip_address = $_SERVER['REMOTE_ADDR'];

require_once('calculateMinutes.php');

$checkAttack = "SELECT * FROM adminattack WHERE ip_address='$ip_address' LIMIT 1";
$checkAttackRes = mysqli_query($con, $checkAttack);

if($checkAttackRes === false){

} else {
    $attack_before = mysqli_num_rows($checkAttackRes);

    $dateNow = date("Y-m-d h:i:sa");

    if($attack_before > 0){

        while($getAttack = mysqli_fetch_array($checkAttackRes)){
            $hacker_attack = $getAttack['hacker_attack'];
            $from_date = $getAttack['date'];
        }

        $from_date = strtotime($from_date);
        $to_date = strtotime($dateNow);

        $diff = calculateMinutes($from_date,$to_date);
        $minutes = $diff;

        if($minutes > 60){ 
            // we should check here and if you don't every user login even 
            // the one that is a week between consider as hacker attack!!!

            $setAttackZero = "UPDATE adminattack SET hacker_attack='0',date='$dateNow' WHERE ip_address='$ip_address'";
            //$setAttackZero = "DELETE FROM blocked WHERE ip_address='$ip_address'";
            $setAttackZeroRes = mysqli_query($con, $setAttackZero);
        } else {
            $hacker_attack += 1;
            $increaseAttack = "UPDATE adminattack SET hacker_attack='$hacker_attack',date='$dateNow' WHERE ip_address='$ip_address'";
            $increaseAttackRes = mysqli_query($con, $increaseAttack);
        }

    } else {
        
        $insertAttack = "INSERT INTO adminattack (hacker_attack,ip_address,date) VALUES ('1','$ip_address','$dateNow')";
        $insertAttackRes = mysqli_query($con, $insertAttack);
        
    }
}

?>