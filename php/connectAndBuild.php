<?php


$tableCreate = "SELECT * FROM users LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_user_select'] = false;

    $createTable = "CREATE TABLE users(
    user_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
    username varchar (50),
    activation varchar(1),
    address varchar (255),
    zipcode varchar (20),
    phone varchar (20) NOT NULL,
    sms varchar (10) NOT NULL,
	province varchar (30),
    city varchar (30),
	ip_address varchar(30),
	register_date varchar (100),
	number_of_shopping int(10),
	star_rating int(10),
	hacker_attack int(10),
    PRIMARY KEY (user_id)
    );";

    $check = mysqli_query($con , $createTable);

    if ( $check == false ) {
        $result['table_user_create'] = $check;
    } else {
        $result['table_user_create'] = $check;
    }
} else {
    $result['table_user_select'] = true;
}



$tableCreate = "SELECT * FROM products LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_products_select'] = false;

    $createTable = "CREATE TABLE products(
    product_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
    title varchar (50) NOT NULL,
    category varchar (50) NOT NULL,
    brand varchar (50) NOT NULL,
    description varchar (255),
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
} else {
    $result['table_products_select'] = true;
}




$tableCreate = "SELECT * FROM orders LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_orders_select'] = false;

    $createTable = "CREATE TABLE orders(
    order_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id int(100) UNSIGNED NOT NULL,
    product_id int(100) UNSIGNED NOT NULL,
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
} else {
    $result['table_orders_select'] = true;
}



$tableCreate = "SELECT * FROM baskets LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_baskets_select'] = false;

    $createTable = "CREATE TABLE baskets(
    basket_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id int(100) UNSIGNED NOT NULL,
    phone varchar (20),
	price varchar (100),
    process varchar (1),
	customer_regret varchar(1),
	payment_check varchar(1),
	date varchar (100),
    PRIMARY KEY (basket_id)
    );";

    $check = mysqli_query($con , $createTable);

    if ( $check == false ) {
        $result['table_baskets_create'] = $check;
    } else {
        $result['table_baskets_create'] = $check;
    }
} else {
    $result['table_baskets_select'] = true;
}



$tableCreate = "SELECT * FROM categories LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_categories_select'] = false;

    $createTable = "CREATE TABLE categories(
    category_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
	category_name varchar (100),
    PRIMARY KEY (category_id)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci";

    $check = mysqli_query($con , $createTable);

    if ( $check == false ) {
        $result['table_categories_create'] = $check;
    } else {
        $result['table_categories_create'] = $check;
    }
} else {
    $result['table_categories_select'] = true;
}




$tableCreate = "SELECT * FROM blocked LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_blocked_select'] = false;

    $createTable = "CREATE TABLE blocked(
    blocked_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
	phone varchar (100),
    ip_address varchar(100),
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (blocked_id)
    );";

    $check = mysqli_query($con , $createTable);

    if ( $check == false ) {
        $result['table_blocked_create'] = $check;
    } else {
        $result['table_blocked_create'] = $check;
    }
} else {
    $result['table_blocked_select'] = true;
}




$tableCreate = "SELECT * FROM adminTable LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_adminTable_select'] = false;

    $createTable = "CREATE TABLE adminTable(
    admin_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
	phone varchar (100),
    sms varchar (100),
    PRIMARY KEY (admin_id)
    );";

    $check = mysqli_query($con , $createTable);

    if ( $check === false ) {
        $result['table_blocked_create'] = $check;
    } else {
        $result['table_blocked_create'] = $check;

        $insertToAdmin = "INSERT INTO adminTable (phone) VALUES ('09381308994')";
        $res = mysqli_query($con, $insertToAdmin);
        if($res === false){

        } else {

        }
    }
} else {
    $result['table_blocked_select'] = true;
}




$tableCreate = "SELECT * FROM saved LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_saved_select'] = false;

    $createTable = "CREATE TABLE saved(
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
} else {
    $result['table_saved_select'] = true;
}






$tableCreate = "SELECT * FROM pictures LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_pictures_select'] = false;

    $createTable = "CREATE TABLE pictures(
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
} else {
    $result['table_pictures_select'] = true;
}




$tableCreate = "SELECT * FROM provinces LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_provinces_select'] = false;

    $createTable = "CREATE TABLE provinces(
    province_id int (100) UNSIGNED NOT NULL AUTO_INCREMENT,
    province_name varchar (100),
    PRIMARY KEY (province_id)
    );";

    $check = mysqli_query($con , $createTable);

    if ( $check === false ) {
        $result['table_provinces_create'] = $check;
    } else {
        $result['table_provinces_create'] = $check;
    }
} else {
    $result['table_provinces_select'] = true;
}





$tableCreate = "SELECT * FROM cities LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_cities_select'] = false;

    $createTable = "CREATE TABLE cities(
    city_id int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
    city_name varchar (100),
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
} else {
    $result['table_cities_select'] = true;
}





$tableCreate = "SELECT * FROM complains LIMIT 1";
$check = mysqli_query($con , $tableCreate);
if($check == false) {
    $result['table_complains_select'] = false;

    $createTable = "CREATE TABLE complains(
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
} else {
    $result['table_complain_select'] = true;
}



//mysqli_close($con);
//echo json_encode($result);
//exit();

?>