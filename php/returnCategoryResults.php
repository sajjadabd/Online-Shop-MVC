<?php
require_once('connect.php');
require_once('functions.php');
$return = array();
//echo print_r($_POST);
//exit();



if(isset($_POST['category_id'])){

} else {
    echo json_encode(array('success'=>false,'set'=>false));
    exit();
}
if( isset($_POST['phone']) && isset($_POST['sms']) ){
	$phone = myFirstSanitize($_POST['phone']);
	$sms = myFirstSanitize($_POST['sms']);
}
$category_id = myFirstSanitize($_POST['category_id']);
$start = myFirstSanitize($_POST['start']);

if(empty($phone) || empty($sms) ){
    //echo json_encode(array('success'=>false,'sanitize'=>false));
    //exit();
   
    if ($category_id == 0) {
		$returnCategoryResults = "SELECT * FROM products LIMIT 10 OFFSET $start";
	} else {
	    $getCategoryID = "SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1";
    	$res = mysqli_query($con , $getCategoryID);
    	
    	$count_category = mysqli_num_rows($res);
    	if($count_category > 0){
    		while( $row = mysqli_fetch_array($res) ) {
    			$category_name = $row['category_name'];
    			//$return[] = $row['category_name'];
    		}
		}
		
		$returnCategoryResults = "SELECT * FROM products WHERE category='$category_name' LIMIT 10 OFFSET $start";
	}
	
} else {
    $checkUser = "SELECT * FROM users WHERE phone='$phone' AND sms='$sms' LIMIT 1";
    $res = mysqli_query($con , $checkUser);
    
    if($res == false){
    	echo json_encode(array('success'=>false,'database_error'=>true));
        exit();
    } else {
    	    $count_user = mysqli_num_rows($res);
    	    
    	    if($count_user > 0){
        		while( $row = mysqli_fetch_array($res) )
        		{
        			$user_id = $row['user_id'];
        		}
    	    }
    		
    		
    		$getCategoryID = "SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1";
        	$res = mysqli_query($con , $getCategoryID);
        	
        	$count_category = mysqli_num_rows($res);
        	if($count_category > 0){
        		while( $row = mysqli_fetch_array($res) ) {
        			$category_name = $row['category_name'];
        			//$return[] = $row['category_name'];
        		}
        	}
        	
        	
        	if($count_user > 0 && $category_id == 0){
        		$returnCategoryResults = "SELECT products.*, myOrder.user_id, myOrder.multiply, mySave.save_id FROM products 
                                          LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') 
        								  AS myOrder ON myOrder.product_id=products.product_id	
    									  LEFT JOIN (SELECT * FROM saved WHERE user_id='$user_id') AS mySave	
    									  ON mySave.product_id=products.product_id ORDER BY product_id			  
    									  LIMIT 10 OFFSET $start";
    									  
        	} else if($count_user > 0){
        		$returnCategoryResults = "SELECT products.*, myOrder.user_id, myOrder.multiply, mySave.save_id FROM products 
                                          LEFT JOIN (SELECT * FROM orders WHERE orders.user_id='$user_id' AND orders.activation='0') 
        								  AS myOrder ON myOrder.product_id=products.product_id
    									  LEFT JOIN (SELECT * FROM saved WHERE user_id='$user_id') AS mySave	
    									  ON mySave.product_id=products.product_id	
                                          WHERE products.category='$category_name' ORDER BY product_id							  
    									  LIMIT 10 OFFSET $start";
    									  
        	} else if ($category_id == 0) {
        		$returnCategoryResults = "SELECT * FROM products LIMIT 10 OFFSET $start";
        	    
        	    //echo json_encode(array('here'=>$category_id));
                //exit();
        	} else {
        		$returnCategoryResults = "SELECT * FROM products WHERE category='$category_name' LIMIT 10 OFFSET $start";
        	
        	    //echo json_encode(array('category_id'=>$category_id));
                //exit();
        	}  
    	}
}

$res = mysqli_query($con , $returnCategoryResults);
	
$productData = array();
$productPicture = array();
if($res == false){
	//$return['success'] = false;
} else {
	while( $row = mysqli_fetch_array($res) ) {
		$productData[] = $row;
		$product_id = $row['product_id'];

		$selectPictures = "SELECT * FROM pictures WHERE product_id='$product_id'";
		$resPics = mysqli_query($con,$selectPictures);
		if($resPics === false){

		} else {
			while($pics = mysqli_fetch_array($resPics)){
				$productPicture[] = $pics;
			}
		}
			
		$return[] = array('product'=>$productData,'pictures'=>$productPicture);

		$productData = array();
		$productPicture = array();
	}
	$result['success'] = true; 
}

echo json_encode($return);

?>