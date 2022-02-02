<?php
    if(isset($_GET['url']))
    {
        $url = $_GET['url'];
        $url = explode('/' , rtrim($url , '/'));
    } else {
        $url = array();
    }

    if(!isset($url[0]) || $url[0] === ''){
        $url = array();
        $url[0] = 'home';
        $url[1] = 'index';
    }
    if(!isset($url[1])){
        $url[1] = 'index';
    }

    //print_r($url);
    //exit();
?>


<?php
    if($url[0] === 'admin' && $url[1] === 'login'){
?>

<?php
    } if($url[0] === 'admin' && $url[1] !== 'login'){
?>

<?php
    } if($url[0] === 'home' && $url[1] === 'login'){
?>

<?php
    } if($url[0] === 'home' && $url[1] !== 'login') {
?>


<?php
    }
?>