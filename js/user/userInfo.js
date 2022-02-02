$(document).ready(function(){

	var userSettingForm   = $(".userSettingForm");
	var snackBar2 = $('#snackbar2');
	var snackBar3 = $('#snackbar3');

	var updateUser = $("button#updateUser");
	
	var userConfigurationRemain = $(".userConfigurationRemain");
	var basketNotificationButton = $(".basketNotificationButton");

	var listOfCities = $('#listOfCities');
	var listOfProvinces = $('#listOfProvinces');

	var selectListOfProvinces = $('#selectListOfProvinces');
	var selectListOfCities = $('#selectListOfCities');

	var maskForSelect = $('#maskForSelect');

	var user_selected_province = $('#user_selected_province');
	var user_selected_city = $('#user_selected_city');

	var listOfAllProvinces = $('#listOfAllProvinces');
	var listOfAllCities = $('#listOfAllCities');

	var selected_province;
	
	var phone = '';
	var sms = '';
	
	if (typeof(Storage) !== "undefined") {
	  // Code for localStorage/sessionStorage.
	  if( localStorage.phone !== undefined && localStorage.sms !== undefined ){
		phone = localStorage.phone;
		sms = localStorage.sms;
	  } else {
		phone = getCookie('phone');
		sms = getCookie('sms');
	  }
	} else {
	  // Sorry! No Web Storage support..
	  phone = getCookie('phone');
	  sms = getCookie('sms');
	}
	
	showSnackBar2 = function(){
		snackBar2.addClass("show");
	};

	showSnackBar3 = function(){
		snackBar3.addClass("show");
	};
	
	
	window.onclick = function(event) {
		//snackBar.removeClass("show");
		snackBar2.removeClass("show");
		snackBar3.removeClass("show");
	}

	
	var updateHeaderStatus = function(){
		
		$.ajax({
            url : '/php/returnHeaderStatus.php',
            type : 'post',
            data : {
                phone : phone,
                sms : sms
            },
            beforeSend : function (){

            },
            success : function(data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				if(d.basketNumber > 0){
					basketNotificationButton.text(d.basketNumber);
					basketNotificationButton.css('display','');
				
				}else{
					basketNotificationButton.css('display','none');
					/*
					SubmitBasketContainer.animate({
						opacity: 0
						}, 3000, function() {
						SubmitBasketContainer.css('display', 'none');
						});
						*/
				}
				if(d.configNumber > 0){
					userConfigurationRemain.text(d.configNumber);
					userConfigurationRemain.css('display','');
				} else {
					userConfigurationRemain.css('display','none');
				}
			
            },
            error : function () {
					//console.log("Error On Update Status");
            }
		});
	};

	var live_in_city = $('#live_in_city');
    var live_in_rural = $('#live_in_rural');

    var onStart = function(){

		$.ajax({
			url:'/php/getUserData.php',
			type:'post',
			data:{
				phone : phone,
				sms : sms
			},
			beforeSend : function() {
				showLoadingBar();
				hideSubmitButton();
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);

				userSettingForm.find('[name]').each(function(index,value) {
					name = $(this).attr('name');
					
					if(name=='username')
						$(this).val(d.username);
					if(name=='zipcode')
						$(this).val(d.zipcode);
					if(name=='address')
						$(this).val(d.address);
					if(name=='province')
						$(this).val(d.province);
					if(name=='city')
						$(this).val(d.city);
					
				});

				if(d.live_in_city == 1){
					live_in_city.prop("checked", true);
					live_in_rural.prop("checked", false);
				} else if(d.live_in_city == 0){
					live_in_city.prop("checked", false);
					live_in_rural.prop("checked", true);
				}

				hideLoadingBar();
				showSubmitButton();
			},
			error : function () {
				hideLoadingBar();
				showSubmitButton();
			}
		});
		
		userSettingForm.css('display','');
	
	};
	
	hideSubmitButton = function(){
		updateUser.css('display','none');
	};

	showSubmitButton = function(){
		updateUser.css('display','');
	};
    
	
    
    updateUser.on('click',function(){
		
		data = {};
		
		userSettingForm.find('[name]').each(function(index,value) {

			if(value.getAttribute('name') === 'radio'){
				name = value.getAttribute('id');
				data[name] = value.checked;
                //value.checked = false;
            } else if(value.getAttribute('name') === 'city'){
				name = 'city';
				let city = $('#user_selected_city').text();
				data[name] = city.trim();
			} else if(value.getAttribute('name') === 'province'){
				name = 'province';
				let province = $('#user_selected_province').text();
				data[name] = province.trim();
			} else {
                name = $(this).attr('name');
				value = $(this).val();
				
				data[name] = value;
                //value.value = '';
            }
			
		});
		
		data['phone'] = phone;
		data['sms'] = sms;
		
		//console.log(data);
		//return false;
		
		$.ajax({
			url: '/php/updateUser.php',
			type:'post',
			data : data,
			beforeSend : function () {
				showLoadingBar();
				hideSubmitButton();
			},
			success : function (data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				//snackBar2.addClass("show");
				if(d.success === true){
					showSnackBar2();
					updateHeaderStatus();
				} else {
					showSnackBar3();
				}

				hideLoadingBar();
				showSubmitButton();
				
			},
			error : function () {
				hideLoadingBar();
				showSubmitButton();
			}
		});
	});

	var checkTrueOrFalseForCity = function(city_name,user_city){
		if(city_name === user_city){
			return `
			selected="selected"
			`;
		} else {
			return ``;
		}
	}

	var checkTrueOrFalseForProvince = function(province_name,user_province){
		if(province_name === user_province){
			return `
			selected="selected"
			`;
		} else {
			return ``;
		}
	}


	var setSelectedProvince = function(user_province){
		selected_province = user_province;
	}

	var loadProvinces = function(){
		$.ajax({
			url:'/php/loadProvincesForUserInfo.php',
			type:'post',
			data:{
				phone : phone,
				sms : sms,
			},
			beforeSend : function(){

			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);

				let user_province = d.user_province;
				setSelectedProvince(d.user_province);
				user_selected_province.html(user_province);

				var append_tbody = `
				${d.provinces.map(function(row){
					return `
					<div class="eachName" ${checkTrueOrFalseForProvince(row.province_name,user_province)}>${row.province_name}</div>
					`
				}).join('')}
				`

				//listOfAllProvinces.html(append_tbody);
				selectListOfProvinces.html(append_tbody);
			},
			error : function(){

			}
		});
	}

	loadingCounter = 1;

	var displayDots = function(){
		var appendDots = ``;
		for(let i=0;i<loadingCounter;i++){
			appendDots += `.`;
		}
		return appendDots;
	}

	var waitingForLoadCities = function(){
		loadingCitiesInterval = setInterval(function(){
			user_selected_city.html(`
			${displayDots()}
			`); 
			if(loadingCounter > 3){
				loadingCounter = 1;
			}
			loadingCounter++;
		},100);
	}

	var clearLoadCitiesInterval = function(){
		clearInterval(loadingCitiesInterval);
		loadingCounter = 1;
	}

	//user_selected_city.html(user_city);
	var decideToDisplayTheUserCityOrNot = function(d,user_city){
		let findUserCity = false;
		for(let i=0;i<d.length;i++){
			if(d[i].city_name === user_city){
				user_selected_city.html(user_city);
				findUserCity = true;
			}
		}

		if(findUserCity === true){

		} else {
			user_selected_city.html(d[0].city_name);
		}
	}


	var loadCities = function(){
		//selected_province = listOfProvinces.val();
		waitingForLoadCities();
		//console.log(selected_province);
		setTimeout(function(){
			$.ajax({
				url:'/php/loadCitiesForUserInfo.php',
				type:'post',
				data:{
					phone : phone,
					sms : sms,
					province_name : selected_province,
				},
				beforeSend : function(){
	
				},
				success : function(data){
					clearLoadCitiesInterval();

					var d = data;
					d = JSON.parse(d);
					//console.log(d);
	
					let user_city = d.user_city;
					
					decideToDisplayTheUserCityOrNot(d.cities,d.user_city);
	
					var append_tbody = `
					${d.cities.map(function(row){
						return `
						<div class="eachName" ${checkTrueOrFalseForCity(row.city_name,user_city)}>${row.city_name}</div>
						`
					}).join('')}
					`
	
					//listOfAllCities.html(append_tbody);
					selectListOfCities.html(append_tbody);
				},
				error : function(){
	
				}
			});
		},500);
		
	}

	var delay = function(){
		setTimeout(function(){ 
			
		}, 1000);
	}

	var closeTheSelect = function(){
		maskForSelect.css('display','none');
		selectListOfProvinces.css('display','none');
		selectListOfCities.css('display','none');
	}

	$(document).on('click','#listOfProvinces > div.eachName',function(){
		var text = $(this).text();
		text = text.trim();
		
		selected_province = text;
		//console.log(selected_province);

		loadCities();
	});

	$(document).on('click','div#selectListOfProvinces > div.eachName',function(){
		var text = $(this).text();
		text = text.trim();
		
		selected_province = text;
		//console.log(selected_province);
		user_selected_province.html(text);

		closeTheSelect();
		loadCities();
	});

	$(document).on('click','div#selectListOfCities > div.eachName',function(){
		var text = $(this).text();
		text = text.trim();
		
		//selected_province = text;
		//console.log(selected_province);
		user_selected_city.html(text);

		closeTheSelect();
		//loadCities();
	});


	listOfProvinces.on('click',function(e){
		//alert('Provinces Clicked');
		//e.preventDefault();
		//return false;
		//console.log(selectListOfProvinces);
		selectListOfProvinces.css('display','');
		maskForSelect.css('display','');
	});


	listOfCities.on('click',function(e){
		//alert('Cities Clicked');
		//e.preventDefault();
		//return false;
		//console.log(selectListOfCities);
		selectListOfCities.css('display','');
		maskForSelect.css('display','');
	});

	maskForSelect.on('click',function(){
		closeTheSelect();
	});


	var promise = new Promise(function(resolve, reject) { 
		resolve(loadProvinces());
	}); 
	
	promise.
	then(function(success){
		delay();
	}).
	then(function(success){
		loadCities();
	}).
	then(function (success) { 
		onStart();
	}).
	catch(function (error) { 

	}); 

});