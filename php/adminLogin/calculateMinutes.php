<?php


function calculateMinutes($from_date,$to_date){

    $from_date_year   = (int) date('Y', $from_date);
    $from_date_month  = (int) date('m', $from_date);
    $from_date_day    = (int) date('d', $from_date);
    $from_date_hour   = (int) date('h', $from_date);
    $from_date_minute = (int) date('i', $from_date);

    $to_date_year   = (int) date('Y', $to_date);
    $to_date_month  = (int) date('m', $to_date);
    $to_date_day    = (int) date('d', $to_date);
    $to_date_hour   = (int) date('h', $to_date);
    $to_date_minute = (int) date('i', $to_date);

    $from_minutes = $from_date_year*12*30*24*60 + 
                    $from_date_month*30*24*60 +
                    $from_date_day*24*60 +
                    $from_date_hour*60 +
                    $from_date_minute;

    $to_minutes =   $to_date_year*12*30*24*60 +
                    $to_date_month*30*24*60 +
                    $to_date_day*24*60 +
                    $to_date_hour*60 +
                    $to_date_minute ;


    $diff = $to_minutes - $from_minutes;

    return $diff;
}

?>