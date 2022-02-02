<?php

if (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') {
    $domain = substr($_SERVER['HTTP_HOST'], 4);
    $redirect= "https://".$domain.$_SERVER['REQUEST_URI'];
    header("Location: $redirect"); 
    exit();
} else {
    $domain = $_SERVER['HTTP_HOST'];
}


if (!$_SERVER['HTTPS']) {
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect"); 
    exit();
} 

?>