$(document).ready(function(){

	var orders_tbody   = $("#orders_tbody");
	
	var start = 0;
	var startLoading = false;

	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 340;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			watchOrders();
		}

		//console.log(startLoading);
		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});

    
	var watchOrders = function(){

		$.ajax({
			url: '/php/watchOrders.php',
			type : 'post',
			data : {
				start : start
			},
			beforeSend : function() {

			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);
				
				if(d.length > 0){
					start += 20;
					startLoading = false;

					var append_tbody = `
					${d.map(function(row){
						return `
						<tr>
						<td>${row.order_id}</td>
						<td>${row.product_id}</td>
						<td>${row.user_id}</td>
						<td>${row.multiply}</td>
						<td>${row.activation}</td>
						<td>${row.basket_id}</td>
						</tr>
						`
					}).join('')}
					`;
	
					orders_tbody.append(append_tbody);
				} else {
					startLoading = true;
				}
			},
			error : function () {
				console.log("Error Happens On Ajax");
			}
		});
	};

	watchOrders();

});