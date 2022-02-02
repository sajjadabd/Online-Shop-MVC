$(document).ready(function () {

    var loading           = $("#loading");
    var entranceButton    = $("#entranceButton");
	var categoryBars      = $("#bars");
	
	
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


	var userConfigurationRemain = $(".userConfigurationRemain");
	var basketNotificationButton = $(".basketNotificationButton");
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

	updateHeaderStatus();
	
	showCategoryBars = function() {
		categoryBars.css('display','');
		//also we want show input search
		$("input#search").css('display','');
	}

	hideCategoryBars = function() {
		categoryBars.css('display','none');
		//also we want hide input search
		$("input#search").css('display','none');
	}

	showLoadingBar = function() {
		loading.css("display","");
	};

	hideLoadingBar = function() {
		loading.css("display","none");
	};


	entranceButton.on('click',function(){
        window.location.href = "../login/";
	});
	

	$("button.enterToShop").on('click',function(){
		window.location.href = "../login/"
	});
	
	
	
});