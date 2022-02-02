<?php
require_once('connect.php');

$createTable = "CREATE TABLE IF NOT EXISTS users(
user_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
username varchar (50),
activation varchar(1),
address varchar (255),
zipcode varchar (20),
phone varchar (20) NOT NULL,
sms varchar (10) NOT NULL,
province varchar (30),
city varchar (30),
live_in_city varchar (30), 
ip_address varchar(30),
register_date varchar (100),
number_of_shopping int(10),
star_rating int(10),
PRIMARY KEY (user_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_user_create'] = $check;
} else {
    $result['table_user_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS products(
product_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
title varchar (50) NOT NULL,
category varchar (50) NOT NULL,
brand varchar (50) NOT NULL,
description varchar (255),
product_color varchar (20),
stock int(100),
price varchar (20) NOT NULL,
original varchar(10) ,
PRIMARY KEY (product_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_product_create'] = $check;
} else {
    $result['table_product_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS orders(
order_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id int(100) UNSIGNED NOT NULL,
product_id int(100) UNSIGNED NOT NULL,
title varchar (50) NOT NULL,
brand varchar (50) NOT NULL,
price varchar (50) NOT NULL,
description varchar (200) NOT NULL,
multiply int(100) UNSIGNED NOT NULL,
activation varchar (1) NOT NULL,
basket_id varchar(20),
PRIMARY KEY (order_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_orders_create'] = $check;
} else {
    $result['table_orders_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS baskets(
basket_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id int(100) UNSIGNED NOT NULL,
basket_number int(100),
username varchar (255),
phone varchar (30),
basket_price varchar (100),
basket_post_price varchar (50),
process varchar (1),
customer_regret varchar(1),
payment_check varchar(1),
refID varchar (100),
authority varchar (200),
date varchar (100),
PRIMARY KEY (basket_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_baskets_create'] = $check;
} else {
    $result['table_baskets_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS categories(
category_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
category_name varchar (50),
category_order int (50),
PRIMARY KEY (category_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_categories_create'] = $check;
} else {
    $result['table_categories_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS blocked(
blocked_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
ip_address varchar(30),
hacker_attack int (20),
date DATETIME,
PRIMARY KEY (blocked_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_blocked_create'] = $check;
} else {
    $result['table_blocked_create'] = $check;
}



$createTable = "CREATE TABLE IF NOT EXISTS adminattack(
adminattack_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
ip_address varchar(30),
hacker_attack int (20),
date DATETIME,
PRIMARY KEY (adminattack_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check == false ) {
    $result['table_adminattack_create'] = $check;
} else {
    $result['table_adminattack_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS adminTable(
admin_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
phone varchar (100),
sms varchar (100),
PRIMARY KEY (admin_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_adminTable_create'] = $check;
} else {
    $result['table_adminTable_create'] = $check;
    
    $checkAdminTableIsEmpty = "SELECT * FROM adminTable";
    $adminTableRes = mysqli_query($con , $checkAdminTableIsEmpty);
    
    if($adminTableRes === false){
        
    } else {
        $count_admin = mysqli_num_rows($adminTableRes);
        if( $count_admin < 1 ){
            $insertToAdmin = "INSERT INTO adminTable (phone) VALUES ('09381308994')";
            $res = mysqli_query($con, $insertToAdmin);
        }
    }
}




$createTable = "CREATE TABLE IF NOT EXISTS saved(
save_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id varchar (100),
product_id varchar (100),
PRIMARY KEY (save_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_saved_create'] = $check;
} else {
    $result['table_saved_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS pictures(
picture_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
product_id varchar (100),
file_destination varchar (100),
picture_alt varchar (100),
PRIMARY KEY (picture_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_pictures_create'] = $check;
} else {
    $result['table_pictures_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS provinces(
province_id int (100) UNSIGNED NOT NULL AUTO_INCREMENT,
province_name varchar (100),
province_order int(50),
PRIMARY KEY (province_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_provinces_create'] = $check;
} else {
    $result['table_provinces_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS cities(
city_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
city_name varchar (100),
post_price int (50),
rural_post_price int (50),
city_order int(50),
province_id int (100),
province_name varchar (100),
PRIMARY KEY (city_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_cities_create'] = $check;
} else {
    $result['table_cities_create'] = $check;
}




$createTable = "CREATE TABLE IF NOT EXISTS complains(
complain_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id varchar (100),
phone varchar (100),
complain_title varchar (255),
complain_text varchar (255),
PRIMARY KEY (complain_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_complain_create'] = $check;
} else {
    $result['table_complain_create'] = $check;
}



$createTable = "CREATE TABLE IF NOT EXISTS payments(
payment_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id varchar (100),
username varchar (255),
phone varchar (30),
authority varchar (255),
price varchar(100),
success varchar (1),
PRIMARY KEY (payment_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_payments_create'] = $check;
} else {
    $result['table_payments_create'] = $check;
}



$createTable = "CREATE TABLE IF NOT EXISTS visit(
visit_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
ip_address varchar (100),
date varchar (100),
PRIMARY KEY (visit_id)
);";

$check = mysqli_query($con , $createTable);

if ( $check === false ) {
    $result['table_visit_create'] = $check;
} else {
    $result['table_visit_create'] = $check;
}


?>