$(document).ready(function(){

	var users_tbody = $("#users_tbody");
	
	var start = 0;
	var startLoading = false;

	var weAreInSearch = false;
	var searchTerm = '';

	var loading = $('#loading');

	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 340;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			//showUsers();

			if( weAreInSearch === true){
				searchUsersFunction(searchTerm);
			} else {
				showUsers();
			}
		}

		//console.log(startLoading);
		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});




    var showUsers = function(){

		$.ajax({
			url: '/php/watchViews.php',
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

				if( d.length > 0) {
					start += 10;
					startLoading = false;

					var append_tbody = `
					${d.map(function(row){
						return `
						<tr>
						<td>${row.visit_id}</td>
						<td>${row.ip_address}</td>
						<td>${row.date}</td>
						</tr>
						`
					}).join('')}
					`;
					users_tbody.append(append_tbody);

					loading.css('display','none');
				} else {
					startLoading = true;

					loading.css('display','none');
				}

				
			},
			error : function () {
				console.log("Error Happens on watchUsers");
				loading.css('display','none');
			}
		});
	};




	var inputProductSearch = $("input#productSearch");
	var sendSearchRequest = false;
	var isThereAnotherSearch = false;
	var prev_value = '';
	//var loading = $('#loading');
	//var products_tbody = $('#products_tbody');

	var searchUsersFunction = function(searchTerm){

			$.ajax({
			url :'/php/searchViewsForAdmin.php',
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
						<td>${row.visit_id}</td>
						<td>${row.ip_address}</td>
						<td>${row.date}</td>
						</tr>
						`
					}).join('')}
					`;
	
					loading.css('display','none');
					users_tbody.append(append_tbody);

					
					//sendSearchRequest = false; // don't uncomment or you will f*
	
					if(isThereAnotherSearch == true){
						isThereAnotherSearch = false;
						sendSearchRequest = true;
						var searchTerm = inputProductSearch.val();
						searchUsersFunction(searchTerm);
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
		users_tbody.html('');
		

		if(searchTerm == prev_value){
			return false;
		}
		
		if( searchTerm === '' ){
			weAreInSearch = false;
			startLoading = false; 
			showUsers();
			return false;
		}

		//console.log(sendSearchRequest);
		
		if( sendSearchRequest == false ){
			sendSearchRequest = true;
			searchUsersFunction(searchTerm);
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
	
	var distinct_people = $('#distinct_people');
	
	var displayDistinctPeople = function(){
	    //distince_people
	    $.ajax({
			url: '/php/watchViewsDistinctPeople.php',
			type : 'post',
			data : {
				
			},
			beforeSend : function() {
				
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

                distinct_people.html(`${d.distinct}`);
			},
			error : function () {
			    
			}
		});
	}

    
    var promise = new Promise(function(resolve, reject) { 
		resolve(showUsers());
	}); 
	
	promise. 
	then(function (success) { 
	    displayDistinctPeople();
	}). 
	catch(function (error) { 

	});
	

});