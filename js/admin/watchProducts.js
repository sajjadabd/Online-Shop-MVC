$(document).ready(function(){

	var products_tbody = $("#products_tbody");
	

	var start = 0;
	var startLoading = false;

	var weAreInSearch = false;
	var searchTerm = '';

	
	var loading = $('#loading');

	$(window).scroll(function(){
		//console.log('start : ' + start);
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height() ;
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 250;
		

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			if( weAreInSearch === true){
				searchProductsFunction(searchTerm);
			} else {
				watchProducts();
			}
		}

		//console.log(startLoading);
		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});



    var watchProducts = function(){
		
		$.ajax({
			url: '/php/watchProducts.php',
			type : 'post',
			data : {
				start : start
			},
			beforeSend : function() {
				loading.css('display','');
			},
			success : function(data) {

				var d = data;
				d = JSON.parse(d);
				console.log(d);

				if(d.length > 0){
					start += 10;
					startLoading = false;

					var append_tbody = `
					${d.map(function(row){
						return `
						<tr>
						<td>${row.product_id}</td>
						<td>${row.title}</td>
						<td>${row.category}</td>
						<td>${row.brand}</td>
						<td>${row.description}</td>
						<td>${row.stock}</td>
						<td><img src="${row.file_destination}"/></td>
						<td>${row.price}</td>
						<td id="trash_${row.product_id}"><i class="fas fa-trash-alt"></i></td>
						</tr>
						`
					}).join('')}
					`;

					loading.css('display','none');
					products_tbody.append(append_tbody);

				} else {
					startLoading = true;
					start = 0;
					loading.css('display','none');
				}
				
			},
			error : function () {
				console.log("Error Happens On Ajax");
			}
		});
	};

	watchProducts();




	var inputProductSearch = $("input#productSearch");
	var sendSearchRequest = false;
	var isThereAnotherSearch = false;
	var prev_value = '';
	//var products_tbody = $('#products_tbody');

	var searchProductsFunction = function(searchTerm){

			$.ajax({
			url :'/php/searchProductsForAdmin.php',
			type:'post',
			data:{
			searchTerm : searchTerm,
			start : start
			},
			beforeSend: function() {
				loading.css('display','');
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				sendSearchRequest = false;
				
				if ( d.length > 0 ){
					start += 10;
					startLoading = false;

					var append_tbody = `
					${d.map(function(row){
						return `
						<tr>
						<td>${row.product_id}</td>
						<td>${row.title}</td>
						<td>${row.category}</td>
						<td>${row.brand}</td>
						<td>${row.description}</td>
						<td>${row.stock}</td>
						<td><img src="${row.file_destination}"/></td>
						<td>${row.price}</td>
						<td id="trash_${row.product_id}"><i class="fas fa-trash-alt"></i></td>
						</tr>
						`
					}).join('')}
					`;
	
					loading.css('display','none');
					products_tbody.append(append_tbody);

					
					//sendSearchRequest = false; // don't uncomment or you will f*
	
					if(isThereAnotherSearch == true){
						isThereAnotherSearch = false;
						sendSearchRequest = true;
						var searchTerm = inputProductSearch.val();
						searchProductsFunction(searchTerm);
					}

				} else {
					startLoading = true;
					start = 0;
					loading.css('display','none');
				}
			},
			error : function() {
				
			}
		});
	}


	var delaySearch = function(){
		start = 0;
		searchTerm = inputProductSearch.val();
		searchTerm = $.trim(searchTerm);
		weAreInSearch = true;
		products_tbody.html('');
		

		if(searchTerm == prev_value){
			return false;
		}
		
		if( searchTerm === '' ){
			weAreInSearch = false;
			startLoading = false; 
			watchProducts();
			return false;
		}

		//console.log(sendSearchRequest);
		
		if( sendSearchRequest == false ){
			sendSearchRequest = true;
			searchProductsFunction(searchTerm);
		} else {
			isThereAnotherSearch = true;	
		}

		prev_value = searchTerm;
		
	}
	
	var searchTimeOut;

	inputProductSearch.keyup(function(){
		clearTimeout(searchTimeOut);
        searchTimeOut = setTimeout(function(){ 
            delaySearch();
        }, 1000); 
				
	});

});