$(document).ready(function(){

    var addItemButton = $('#addItemButton');
    var form = $('#form');
    //var informations = form.querySelectorAll('[name]');
    var picture = document.getElementById('file');
    var formData = new FormData();
    var send_item_data = false;
    
    
    var admin_phone = '';
    var admin_sms = '';
	
	if (typeof(Storage) !== "undefined") {
	  // Code for localStorage/sessionStorage.
	  if( localStorage.admin_phone !== undefined && localStorage.admin_sms !== undefined ){
		admin_phone = localStorage.admin_phone;
		admin_sms = localStorage.admin_sms;
	  } else {
		admin_phone = getCookie('admin_phone');
		admin_sms = getCookie('admin_sms');
		
		localStorage.admin_phone = admin_phone;
		localStorage.admin_sms = admin_sms;
	  }
	} else {
	  // Sorry! No Web Storage support..
	  admin_phone = getCookie('admin_phone');
	  admin_sms = getCookie('admin_sms');
	}
    

    var upload = function (files) {
        for (i = 0; i < files.length; i++) {
            //console.log(files[i].name);
            formData.append('myFile[]', files[i]);
        }
    };

    picture.ondrop = function (e) {
        e.preventDefault();
        upload(e.dataTransfer.files);
        //console.log(e.dataTransfer.files);
        return false;
    };

    picture.ondragover = function () {
        picture.classList.add('green');
        return false;
    };

    picture.ondragleave = function () {
        picture.classList.remove('green');
        return false;
    };

    resetAllInput = function () {
        formData = new FormData();
        picture.classList.remove('green');

        form.find('[name]').each(function(index,value){
            //console.log(value.getAttribute('name'));
            if(value.getAttribute('name') === 'original'){
                value.checked = false;
            } else {
                //console.log(value.value);
                value.value = '';
            }
        });

    };

    
    var progressShake = -100;
    var progressInterval;
    var goUp = true;
    
    var playProgress = function(){
        $('.progressbarText').text('100% - processing...');
        progressInterval = setInterval(function(){
            $('.greenbar').css('left', progressShake + '%');
            
            if( progressShake <= -100 ){
                goUp = true;
            } else if ( progressShake >= 100) {
                goUp = false;
            } 
            
            if(goUp){
                progressShake++;
            } else {
                progressShake--;
            }
            
        },1);
    }

    addItemButton.on('click', function () {
        //console.log('clicked');
        if(send_item_data == false){
            send_item_data = true;
        } else {
            return false;
        }


        form.find('[name]').each(function(index,value){
            //console.log(value.getAttribute('name'));
            if(value.getAttribute('name') === 'original'){
                //console.log(value.checked);
                formData.append(value.name, value.checked);
            } else {
                //console.log(value.value);
                formData.append(value.name, value.value);
            }
        });

        // formData.append('title', data.title);
        // formData.append('category', data.category);
        // formData.append('brand', data.brand);
        // formData.append('price', data.price);
        // formData.append('original', data.original);

        
        // console.log(formData.get('title'));
        // console.log(formData.get('category'));
        // console.log(formData.get('brand'));
        // console.log(formData.get('price'));
        // console.log(formData.get('original'));
        
        $.ajax({
            url: '/php/addItem.php',
            type: 'post',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            data: formData,
            beforeSend: function () {
                //console.log('start uploading files...');
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        //console.log(`percent : ${percentComplete} %`);
                        $('.progressbarText').text(percentComplete + '%');
                        $('.greenbar').css('left', -100+percentComplete + '%');

                        if(percentComplete === 100){
                            playProgress();
                        }
                    }
                }, false);

                return xhr;
            },
            success: function (data) {
                clearInterval(progressInterval);
                $('.greenbar').css('left', '0%');
                $('.progressbarText').text('Done');
                resetAllInput();
                
                var d = data;
                d = JSON.parse(d);
                console.log(d);

                send_item_data = false;
            },
            error: function () {

                send_item_data = false;
            }
        });
        
    });



    var onStart = function(){

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
				${d.map(function (row) {
				return `
				<option>${row.category_name}</option>
				`
				}).join('')}
				`;

				$("#selectInsertProduct").html(append_tbody);
			},
			error : function() {

			}
		});

	};
	
	
	var setAdminSession = function() {
	    $.ajax({
    	    url : '/php/adminLogin/setAdminSession.php',
    	    type : 'post',
    	    data : {
    	        phone : admin_phone,
    	        sms : admin_sms
    	    },
    	    beforeSend : function(){
    	        
    	    },
    	    success : function(data){
    	        var d = data;
    	        d = JSON.parse(d);
    	        console.log(d);
    	        
    	        if(d.count === 0){
    	            localStorage.removeItem("admin_phone");
    	            localStorage.removeItem("admin_sms");
    	            deleteCookie("admin_phone");
    	            deleteCookie("admin_sms");
    	        } else if(d.set === false){
    	            localStorage.removeItem("admin_phone");
    	            localStorage.removeItem("admin_sms");
    	            deleteCookie("admin_phone");
    	            deleteCookie("admin_sms");
    	        }
    	    },
    	    error : function(){
    	        
    	    }
    	});
	}
	
	
	var promise = new Promise(function(resolve, reject) { 
		resolve(setAdminSession());
	}); 
	
	promise. 
	then(function (success) { 
		onStart();
	}). 
	catch(function (error) { 

	}); 
	
	
	
    

});