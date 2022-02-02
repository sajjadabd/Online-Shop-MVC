<?php

class Home extends Controller{

    public function __construct(){
        parent::__construct();
    }
    
    public function index(){

        Home::shop();
        //echo 'This is Index';
        //parent::model($name);
        //call_user_func_array('parent::' . $method, array('name'=>$name));
        //call_user_func_array(['User.php','model'], $name);
    }

    public function shop(){
        
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/shop.php');
    }

    public function saved(){
        //echo 'This is saved';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/saved.php');
    }

    public function userInfo(){
        //echo 'This is UserInfo';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/userInfo.php');
    }

    public function cartList(){
        //echo 'This is cartList';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/cartList.php');
    }

    public function cart(){
        //echo 'This is cart';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/cart.php');
    }

    public function out_of_range(){
        //echo 'error : 404';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/error404.php');
    }

    public function products($product_id = ''){
        //echo count($id);
        if( is_numeric($product_id) === false ){
            Home::out_of_range();
        } else {
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/products.php');
        }
        
    }

    public function login(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/login.php');
    }

    public function logout(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/logout.php');
    }
    
    public function laws(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/laws.php');
    }
    
    public function aboutUs(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/aboutUs.php');
    }
    
    public function contactUs(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/contactUs.php');
    }
    
    public function questions(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/questions.php');
    }
    
    public function complains(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/complains.php');
    }

    public function PaymentCallBack(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/PaymentCallBack.php');
    }

    public function successfulPayment($Authority = ''){
        if( is_numeric($Authority) === false ){
            Home::out_of_range();
        } else {
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/successfulPayment.php');
        }
    }

    public function badPayment(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/user/badPayment.php');
    }
    
    // public function test($product = '', $price = ''){
    // }
}



?>