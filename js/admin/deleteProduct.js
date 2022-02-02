$(document).ready(function(){
    
    var modal_delete_product = $("#myModal-delete-item");
	var close_modal = $("span.close-delete-item");
	
	var product_to_be_deleted ;
	var hide_product_parent;
	
	var delete_item_accept = $("button#deleteItemButton");
	
	var delete_item_func = function(product_id){
		$.ajax({
			url :  '/php/deleteProduct.php',
			type: 'post',
			data: {
				product_id: product_id
			},
			beforeSend : function() {
				
			},
			success: function(data){
				var d = data;
				d = JSON.parse(d);
				console.log(d);
				
				hide_product_parent.fadeOut('slow');
			},
			error : function() {
				
			}
		});
	};
	
	delete_item_accept.on('click',function(){
		delete_item_func(product_to_be_deleted);
		modal_delete_product.css('display','none');
	});
	
	close_modal.on('click',function(){
		modal_delete_product.css('display','none');
	});
	
	$(document).on('click','i.fa-trash-alt',function(){
		hide_product_parent = $(this).parent().parent();
		product_to_be_deleted = $(this).parent().attr('id');
		var tempID = product_to_be_deleted.split("_");
		product_to_be_deleted = tempID[1];
		console.log(product_to_be_deleted);
		modal_delete_product.css('display','block');
	});
});