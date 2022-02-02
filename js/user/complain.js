$(document).ready(function(){
	
	var submitComplain = $('#submitComplain');
	
	var complainForm = $('.userSettingForm');

	var snackBar = $('#snackbar');
	var snackBar2 = $('#snackbar2');
	
	var formData = new FormData();
	
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


	showSnackBar = function(){
		snackBar.addClass("show");
	};

	showSnackBar2 = function(){
		snackBar2.addClass("show");
	};



	window.onclick = function(event) {
		snackBar.removeClass("show");
		snackBar2.removeClass("show");
	}
	
	
	submitComplain.on('click',function(){
	    
	    if( phone === undefined || sms === undefined || phone === null || sms === null ){
	        Swal.fire(
				'',
				`<div class="fontFarsi">
				برای ثبت انتقاد ابتدا باید وارد نکا بیوتی شوید
                </div>
                <div class="fontFarsi">
                <a href="https://nekabeauty.com/home/login/">ورود به نکا بیوتی</a>
                </div>
                `,
                'error'
			  )
			  
		    return false;
	    }
		
		formData = new FormData();
		//console.log('submit complain');
		var empty = false;
		
		complainForm.find('[name]').each(function(index,value){
			//console.log(value.value);
			if( $.trim(value.value) === '' ){
				Swal.fire(
					'',
					'<div class="fontFarsi">موضوع و متن انتقاد را تکمیل کنید</div>',
					'error'
				  )
				empty = true;
			} 
			formData.append(value.name, $.trim(value.value));
		});
		
		if(empty === true){
			
			return false;
		}

		formData.append('phone',phone);
		formData.append('sms',sms);
		
		$.ajax({
			url : '/php/submitComplain.php',
			type : 'post',
			contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
			processData: false, // NEEDED, DON'T OMIT THIS
			data : formData,
			beforeSend : function(){
				
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				

				if(d.success === true){
					showSnackBar();

					complainForm.find('[name]').each(function(index,value){
						//console.log(value.value);
						//formData.append(value.name, value.value);
						value.value = '';
					});
				} else {
					showSnackBar2();
				}

				
			},
			error : function(){
				
			}
		});
	});
	
});