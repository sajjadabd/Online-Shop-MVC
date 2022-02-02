$(document).ready(function(){

    var addCategoryInput = $("#addCategoryInput");
	var addCategoryButton = $("#addCategoryButton");
	
	var addProvinceInput = $('#addProvinceInput');
	var addProvinceButton = $('#addProvinceButton');
	
	var addCityInput = $('#addCityInput');
	var cityPostPrice = $('#post_price');
	var ruralPostPrice = $('#rural_post_price');
	var addCityButton = $('#addCityButton');
	
	var selectedProvince = $('#selectedProvince');
	

	var listProvince = $('#listProvince');
	var listCity = $('#listCity');

	var province_name = 'مازندران';
	
	addProvinceButton.on('click',function(){
		//console.log('submit province');
		
		var province = addProvinceInput.val();
		
		$.ajax({
			url:'/php/addProvince.php',
			type:'post',
			data:{
				province : province
			},
			beforeSend : function(){
				
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				if(d.success === true){
					onStartLoadListOfProvince();
					loadProvincesForSelectOption();
					addProvinceInput.val('');
				}
				
			},
			error : function() {
				
			}
		});
	});
	
	
	addCityButton.on('click',function(){
		//console.log('submit city');
		
		var province = selectedProvince.val();
		var city = addCityInput.val();
		var post_price = cityPostPrice.val();
		var rural_post_price = ruralPostPrice.val();
		
		
		$.ajax({
			url:'/php/addCity.php',
			type:'post',
			data:{
				province : province,
				city : city,
				post_price : post_price,
				rural_post_price : rural_post_price
			},
			beforeSend : function(){
				
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				if(d.success === true){
					onStartLoadListOfCity();

					addCityInput.val('');
					//cityPostPrice.val('');
					//ruralPostPrice.val('');
				}

			},
			error : function() {
				
			}
		});
	});
	

    addCategoryButton.on('click',function(){
		//console.log("Add Category");
		
		var newCategory = addCategoryInput.val();

		$.ajax({
			url : '/php/addCategory.php',
			type: 'post',
			data:{
				category : newCategory
			},
			beforeSend: function(){

			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				if(d.success === true){
					onStartLoadListOfCategory();
					addCategoryInput.val('');
				}
				
			},
			error: function(){

			}
		});
	});

	$(document).on('click','i.fa-trash-alt',function(){
		hide_product_parent = $(this).parent().parent();
		category_to_be_deleted = $(this).parent().attr('id');
		var tempID = category_to_be_deleted.split("_");
		var extraData = tempID[0];
		category_to_be_deleted = tempID[1];
		console.log('extraData : ' + extraData);
		console.log('id : ' + category_to_be_deleted);
		//modal_delete_product.css('display','block');

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		  }).then((result) => {
			console.log(result.value);
			if (result.value) {
				/*
			  Swal.fire(
				'Deleted!',
				'Your file has been deleted.',
				'success'
			  )
			  */
			  if( extraData === 'province' ){
				console.log('delete province');

				$.ajax({
					url : '/php/deleteProvince.php',
					type: 'post',
					data : {
					  province_id : category_to_be_deleted
					},
					beforeSend : function() {
  
					},
					success : function(data){
						var d = data;
						d = JSON.parse(d);
						console.log(d);
  
						//hide_product_parent.fadeOut("slow");
						var deleteProvincePromise = new Promise(function(resolve, reject) { 
							resolve(onStartLoadListOfProvince());
						}); 
						
						deleteProvincePromise. 
						then(function (success) { 
							onStartLoadListOfCity();
						}). 
						then(function(success){
							loadProvincesForSelectOption();
						}).
						catch(function (error) { 
					
						}); 
						
						
					},
					error : function(){
  
					}
				});
			  } else if( extraData === 'city' ){
				console.log('delete city');

				$.ajax({
					url : '/php/deleteCity.php',
					type: 'post',
					data : {
					  city_id : category_to_be_deleted
					},
					beforeSend : function() {
  
					},
					success : function(data){
						var d = data;
						d = JSON.parse(d);
						console.log(d);
  
						//hide_product_parent.fadeOut("slow");
						onStartLoadListOfCity();
					},
					error : function(){
  
					}
				});
			  } else if( extraData === 'category' ) {
				console.log('delete category');
				$.ajax({
					url : '/php/deleteCategory.php',
					type: 'post',
					data : {
					  category_id : category_to_be_deleted
					},
					beforeSend : function() {
  
					},
					success : function(data){
						var d = data;
						d = JSON.parse(d);
						console.log(d);
  
						//hide_product_parent.fadeOut("slow");
						onStartLoadListOfCategory();
					},
					error : function(){
  
					}
				});
  
			  }
			  
			  
			}
		  })
	});


	$(document).on('click','i.fa-minus-square',function(){
		hide_product_parent = $(this).parent().parent();
		item_to_be_decreased = $(this).parent().attr('id');
		var tempID = item_to_be_decreased.split("_");
		var extraData = tempID[0];
		item_to_be_decreased = tempID[1];
		console.log('extraData : ' + extraData);
		console.log('id : ' + item_to_be_decreased);
		//modal_delete_product.css('display','block');

		
		if( extraData === 'province' ){
			console.log('delete province');

			$.ajax({
				url : '/php/changeProvinceOrder.php',
				type: 'post',
				data : {
				  province_id : item_to_be_decreased,
				  order : -1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfProvince();
				},
				error : function(){

				}
			});
		  } else if( extraData === 'city' ){
			console.log('delete city');

			$.ajax({
				url : '/php/changeCityOrder.php',
				type: 'post',
				data : {
				  city_id : item_to_be_decreased,
				  order : -1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfCity();
				},
				error : function(){

				}
			});
		  } else if( extraData === 'category' ) {
			console.log('delete category');
			$.ajax({
				url : '/php/changeCategoryOrder.php',
				type: 'post',
				data : {
				  category_id : item_to_be_decreased,
				  order : -1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfCategory();
				},
				error : function(){

				}
			});

		  }

	});

	$(document).on('click','i.fa-plus-square',function(){
		hide_product_parent = $(this).parent().parent();
		item_to_be_increased = $(this).parent().attr('id');
		var tempID = item_to_be_increased.split("_");
		var extraData = tempID[0];
		item_to_be_increased = tempID[1];
		console.log('extraData : ' + extraData);
		console.log('id : ' + item_to_be_increased);
		//modal_delete_product.css('display','block');


		
		if( extraData === 'province' ) {
			console.log('delete province');

			$.ajax({
				url : '/php/changeProvinceOrder.php',
				type: 'post',
				data : {
				  province_id : item_to_be_increased,
				  order : 1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfProvince();
				},
				error : function(){

				}
			});
		  } else if( extraData === 'city' ){
			console.log('delete city');

			$.ajax({
				url : '/php/changeCityOrder.php',
				type: 'post',
				data : {
				  city_id : item_to_be_increased,
				  order : 1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfCity();
				},
				error : function(){

				}
			});
		  } else if( extraData === 'category' ) {
			console.log('delete category');
			$.ajax({
				url : '/php/changeCategoryOrder.php',
				type: 'post',
				data : {
				  category_id : item_to_be_increased,
				  order : 1,
				},
				beforeSend : function() {

				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					//hide_product_parent.fadeOut("slow");
					onStartLoadListOfCategory();
				},
				error : function(){

				}
			});

		  }


	});


	$(document).on('click','select#selectedProvince > option',function(){
		var text = $(this).text();
		text = text.trim();
		

		province_name = text;
		console.log(province_name);

		onStartLoadListOfCity();
	});


	var onStartLoadListOfCategory = function(){

		$.ajax({
			url: '/php/loadCategory.php',
			type:'post',
			data:{

			},
			beforeSend: function(){

			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				var append_tbody = `
				<div class="eachCategory">
					<div>category_name</div>
					<div>category_order</div>
					<div>tools</div>
				</div>
				`;

				append_tbody += `
				${d.map(function (row) {
				return `
				<div class="eachCategory">
					<div>${row.category_name}</div>
					<div>${row.category_order}</div>
					<div id="category_${row.category_id}">
						<i class="fa fa-minus-square"></i>
						<i class="fa fa-plus-square"></i>
						<i class="fas fa-trash-alt"></i>
					</div>
				</div>
				`
				}).join('')}
				`;

				$("#listCategory").html(append_tbody);
			},
			error : function() {

			}
		});

	};



	var onStartLoadListOfProvince = function(){

		$.ajax({
			url: '/php/loadProvinces.php',
			type:'post',
			data:{

			},
			beforeSend: function(){

			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				var append_tbody = `
				<div class="eachCategory">
					<div>province_name</div>
					<div>province_order</div>
					<div>tools</div>
				</div>
				`;

				append_tbody += `
				${d.map(function (row) {
				return `
				<div class="eachCategory">
					<div >${row.province_name}</div>
					<div >${row.province_order}</div>
					<div id="province_${row.province_id}">
						<i class="fa fa-minus-square"></i>
						<i class="fa fa-plus-square"></i>
						<i class="fas fa-trash-alt"></i>
					</div>
				</div>
				`
				}).join('')}
				`;

				listProvince.html(append_tbody);
			},
			error : function() {

			}
		});

	};



	var onStartLoadListOfCity = function(){

		$.ajax({
			url: '/php/loadCities.php',
			type:'post',
			data:{
				province_name : province_name,
			},
			beforeSend: function(){

			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				var append_tbody = `
				<div class="eachCategory">
					<div>city_name</div>
					<div>city_order</div>
					<div>post_$</div>
					<div>rural_$</div>
					<div>tools</div>
				</div>
				`;

				if(d.length > 0){					

					append_tbody += `
					${d.map(function (row) {
					return `
					<div class="eachCategory">
						<div >${row.city_name}</div>
						<div>${row.city_order}</div>
						<div>${row.post_price}</div>
						<div>${row.rural_post_price}</div>
						<div id="city_${row.city_id}">
							<i class="fa fa-minus-square"></i>
							<i class="fa fa-plus-square"></i>
							<i class="fas fa-trash-alt"></i>
						</div>
					</div>
					`
					}).join('')}
					`;
	
					listCity.html(append_tbody);
				} else {
					listCity.html(append_tbody);
				}
				
			},
			error : function() {

			}
		});

	};


	var loadProvincesForSelectOption = function(){
		$.ajax({
			url: '/php/loadProvinces.php',
			type:'post',
			data:{
				
			},
			beforeSend: function(){

			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				var append_tbody = `
					${d.map(function(row){
						return `
						<option>${row.province_name}</option>
						`
					}).join('')}
				`;

				selectedProvince.html(append_tbody);
			},
			error : function(){

			}
		});
	}



	var promise = new Promise(function(resolve, reject) { 
		resolve(onStartLoadListOfCategory());
	}); 
	
	promise. 
	then(function (success) { 
		onStartLoadListOfProvince();
	}). 
	then(function(success){
		onStartLoadListOfCity();
	}).
	then(function(success){
		loadProvincesForSelectOption();
	}).
	catch(function (error) { 

	}); 



});