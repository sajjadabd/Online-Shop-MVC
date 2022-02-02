$(document).ready(function () {
    //console.log("start jquery");
    var submitButtons = document.getElementsByClassName("submitButton");
    var textInputs = document.getElementsByClassName("tab");
	
	var allButtons = document.getElementById("allButtons");
	var loading = document.getElementById("loading");
	
	var inputPhone = $("#phone");
	var inputSms = $("#sms");
	
	var snackBar  = $("#snackbar");
	var snackBar2 = $("#snackbar2");
	var snackBar3 = $('#snackbar3');


	var blockTimeRemaining = $('#blockTimeRemaining');
	
	window.onclick = function(event) {
		snackBar.removeClass("show");
		snackBar2.removeClass("show");
		snackBar3.removeClass("show");
	}
	
	inputPhone.on('keyup', function (e) {
		if (e.keyCode == 13) {
			//console.log("press enter");
			$("#submit").focus();
			firstStep();
		}
	});
	
	
	inputSms.on('keydown', function (e) {
		if (e.keyCode == 13) {
			$("#submit").focus();
			//console.log("press enter");
			secondStep();
		}
	});
	
    var prev = 0;
    var nex = 1;
    var submit = 2;
    var currentTextInput = 0;
    plus = function(number) {
    };
	
	hideAllButtons = function()
	{
		for (i = 0; i < textInputs.length; i++) {
            submitButtons[i].style.display = "none";
        }
	}
    next = function (number) {
        currentTextInput += number;
        if (currentTextInput >= textInputs.length - 1)
            currentTextInput = textInputs.length - 1;
        if (currentTextInput <= 0)
            currentTextInput = 0;
        if (currentTextInput == 0) {
            submitButtons[prev].style.display = "none";
            submitButtons[nex].style.display = "";
            submitButtons[submit].style.display = "none";
        }
        else if (currentTextInput == textInputs.length - 1) {
            submitButtons[prev].style.display = "";
            submitButtons[nex].style.display = "none";
            submitButtons[submit].style.display = "";
        }
        else {
            submitButtons[prev].style.display = "none";
            submitButtons[nex].style.display = "none";
            submitButtons[submit].style.display = "none";
        }

        for (i = 0; i < textInputs.length; i++) {
            textInputs[i].style.display = "none";
        }
		
        textInputs[currentTextInput].style.display = "";
        textInputs[currentTextInput].querySelector('input').focus();
        //console.log(currentTextInput);
    };
    
    
    var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
    var arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
    var fixNumbers = function (str)
    {
      if(typeof str === 'string')
      {
        for(var i=0; i<10; i++)
        {
          str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
      }
      return str;
    };
    
	
	var firstStep = function(){
		var phone = $('#phone').val();
		phone = fixNumbers(phone);
		//phone = Number(phone);
		
		if( $.trim(phone) == '' )
		{
			$('#phone').css("background-color", "rgba(255,0,0,.2)");
		}
		else
		{
			$.ajax({
				url: '/php/userLogin.php', // Don't User ../userLogin.php
				type: 'post',
				data: {
					phone: phone,
				},
				beforeSend : function()
				{
					allButtons.style.display = "none";
					loading.style.display = "";
				},
				success: function (data) {
					
					allButtons.style.display = "";
					loading.style.display = "none";
					
					var d = data;
					d = JSON.parse(d);
					//console.log(d);

					if(d.randomNumber !== undefined){
						
						Swal.fire(
							"Entrance Code : ", 
							d.randomNumber + "", 
							"success");
							
					}

					if( d !== undefined ) {
						if(d.success === true)
						{
							next(1);
						} else if( d.secondSanitize === false ) {
							snackBar.addClass("show");
						} else if(d.block === true){
							blockTimeRemaining.text(d.min);
							snackBar3.addClass("show");
						}
					}
					//snackBar.removeClass("show");
					//snackBar.addClass("show");
					
				},
				error: function () {
					//console.log('error happens on ajax!');
					allButtons.style.display = "";
					loading.style.display = "none";
				}
			});
		}
	};
	
	
	
	var secondStep = function() {
		var phone = $('#phone').val();
		var sms = $('#sms').val();
		
		phone = fixNumbers(phone);
		sms = fixNumbers(sms);
		
		//phone = Number(phone);
		//sms   = Number(sms);
		if( $.trim(phone) == '' || $.trim(sms) == '' )
		{
			$('#sms').css("background-color", "rgba(255,0,0,.2)");
		}
		else
		{
			$.ajax({
				url: '/php/userLogin.php', // Don't Use  '../userLogin.php'
				type: 'post',
				data: {
					phone: phone,
					sms: sms,
				},
				beforeSend : function()
				{
					allButtons.style.display = "none";
					loading.style.display = "";
				},
				success: function (data) {
					
					var d = data;
					var d = JSON.parse(d);
					//console.log(d);
					
					if( d !== undefined ) {
						if(d.success === true)
						{
							window.location.href = "../shop/";
							
							//localStorage.setItem("phone",phone);
							//localStorage.setItem("sms",sms);
							if (typeof(Storage) !== "undefined") {
							  // Code for localStorage/sessionStorage.
							  localStorage.phone = phone;
							  localStorage.sms   = sms;
							} 
							setCookie('phone',phone, 356); // set cookie for 365 days
							setCookie('sms'  ,sms  , 356); // set cookie for 365 days

						} else if(d.success === false) {
							allButtons.style.display = "";
							loading.style.display = "none";
							snackBar2.addClass("show");
							
							if (typeof(Storage) !== "undefined") {
							  // Code for localStorage/sessionStorage.
							  localStorage.removeItem("phone");
							  localStorage.removeItem("sms");
							 
							} 
							deleteCookie('phone');
							deleteCookie('sms');

						} else if( d.sanitize === false ) {
							allButtons.style.display = "";
							loading.style.display = "none";
							snackBar2.addClass("show");
							
							if (typeof(Storage) !== "undefined") {
							  // Code for localStorage/sessionStorage.
							  localStorage.removeItem("phone");
							  localStorage.removeItem("sms");
							}
							deleteCookie('phone');
							deleteCookie('sms');

						} else if(d.block === true) {
							allButtons.style.display = "";
							loading.style.display = "none";
							blockTimeRemaining.text(d.min);
							snackBar3.addClass("show");
						}
					}
					
				},
				error: function () {
					//console.log('error happens on ajax!');
				}
			});
		}
	};

	$('#phone').on('focus',function(){
		$(this).css("background-color", "white");
	});

	$('#sms').on('focus',function(){
		$(this).css("background-color", "white");
	});


    $("#nex").on('click', function () {
        //console.log('go next');
        firstStep();
    });
    $("#submit").on('click', function () {
        //console.log('submit form');
        secondStep();
    });
});