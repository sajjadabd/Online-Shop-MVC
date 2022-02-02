<?php

class admin extends Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        admin::addItem();
    }

    public function addItem(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/addItem.php');
    }

    public function editItem(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/editItem.php');
    }

    public function showUsers(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/showUsers.php');
    }

    public function watchOrders(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/watchOrders.php');
    }

    public function watchProducts(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/watchProducts.php');
    }

    public function showBaskets(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/showBaskets.php');
    }

    public function addCategory(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/addCategory.php');
    }

    public function out_of_range(){
        //echo 'error : 404';
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/error404.php');
    }

    public function login(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/login.php');
    }

    public function logout(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/logout.php');
    }

    public function showComplains(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/showComplains.php');
    }
	
	public function showViews(){
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/app/views/admin/showViews.php');
    }
}



?>