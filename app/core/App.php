<?php

class App{

    protected $controller = 'home';
    protected $method = 'shop';
    protected $params = [];

    public function __construct(){
        //echo 'OK!';
        //print_r( $this->parseUrl() );
        //echo $_SERVER['DOCUMENT_ROOT'];
        //exit();
        $url = $this->parseUrl();

        //print_r($_SERVER);
        //$req =  $_SERVER['REDIRECT_URL'];
        //echo $req;


        //print_r($url);

        if(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/'. strtolower($url[0]) .'.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/'.$this->controller.'.php');
        
            if( isset($url[1]) ) {
                if( method_exists( $this->controller, strtolower($url[1]) ) ) {
                    $this->method = $url[1];
                    unset($url[1]);
                    //echo 'i reach 1';
                } else if( preg_match("#^PaymentCallBack(.*)$#i", strtolower($url[1]) )  ) {
                    $this->method = 'PaymentCallBack';
                    unset($url[1]);
                } else if( strtolower($url[1]) === '' ){
                    unset($url[1]);
                } else {
                    $this->method = 'out_of_range';
                    //echo 'i reach 2';
                }
            }

            $this->params = $url ? array_values($url) : [] ;

            if(count($this->params) > 1){
                $this->method = 'out_of_range';
                //echo 'i reach 3';
            }

        } else if( count($url) > 2 ){
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/'.$this->controller.'.php');
            $this->method = 'out_of_range';
            //echo 'i reach 4';
        } else { // $url[0] Not Exist
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/'.$this->controller.'.php');
            
            if(isset($url[0]) && strtolower($url[0]) !== 'home'){
                $this->method = 'out_of_range';
                //echo 'i reach 5';
            } else {
                $this->method = 'index';
            }
        } 

            
        call_user_func_array([$this->controller,$this->method], $this->params);
        
        //print_r($url);
        //echo $this->controller;
        //print_r($this->params);
    }

    public function newline(){
        print '<br />';
    }

    public function addSlashAtEnd($url){
        //echo print_r(parse_url($_SERVER['REQUEST_URI']));
        $len = strlen($url);
        //print $len ;
        //exit();
        //$url = rtrim($url, '/');

        if( $url[$len-1] !== '/' && strpos($url, 'PaymentCallBack') === false){
            
            //App::newline();
            //print $url;
            //print_r($_SERVER);
            //exit();
            $url = $_SERVER['REQUEST_URI'] . '/';
            
            //print $url;
            //exit();
            header("Location: $url");
            exit();
        }

        $tempUrl = $url;

        $tempUrl = explode('/', rtrim($url, '/'));
        //$tempUrl = explode('/', $url);

        //print_r($tempUrl);
        //exit();

        if( $tempUrl[0] === 'home' && !isset($tempUrl[1]) ){
            $url = $_SERVER['REQUEST_URI'] . 'shop/';
            header("Location: $url");
            exit();
        } else if( $tempUrl[0] === 'admin' && !isset($tempUrl[1]) ){
            $url = $_SERVER['REQUEST_URI'] . 'addItem/';
            header("Location: $url");
            exit();
        }
        
    }

    public function parseUrl(){
        if( isset($_GET['url']) ) {
            $url = $_GET['url'];
            //print $url;
            //App::newline();
            //print stripos($url
            
            App::addSlashAtEnd($url);

            //App::newline();

            //$url_explode = explode('/',$url);
            $url_explode = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            //print_r($url_explode);

            return $url_explode;
            //exit();
            //return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        } else {
            $url = $_SERVER['REQUEST_URI'] . 'home/shop/';
            header("Location: $url");
        }
    }
}



?>