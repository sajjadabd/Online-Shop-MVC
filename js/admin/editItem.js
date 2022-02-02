$(document).ready(function(){

    var pictureUpdate    = document.getElementById("file_edit");
	var form_edit        = $("#form_edit");
	var fetchProduct     = $("i.fa-download");
	var formDataUpdate   = new FormData();
	var editItemButton = $("#editItemButton");
	//var loading = $('#loading');
	
	
	var upload = function (files) {
		for (i = 0; i < files.length; i++) {
			//console.log(files[i].name);
			formDataUpdate.append('myFile[]', files[i]);
		}
	};

	pictureUpdate.ondrop = function (e) {
		e.preventDefault();
		upload(e.dataTransfer.files);
		//console.log(e.dataTransfer.files);
		return false;
	};

	pictureUpdate.ondragover = function () {
		pictureUpdate.classList.add('green');
		return false;
	};

	pictureUpdate.ondragleave = function () {
		pictureUpdate.classList.remove('green');
		return false;
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
	
	
	editItemButton.on('click', function(){
		//console.log("Update Item");
		
		form_edit.find('[name]').each(function(index,value){
			//console.log(value.value);
			
			if(value.getAttribute('name') === 'original'){
                //console.log(value.checked);
                formDataUpdate.append(value.name, value.checked);
            } else {
                //console.log(value.value);
                formDataUpdate.append(value.name, value.value);
            }
			
		});
		
		
		$.ajax({
			url:'/php/updateProductForAdmin.php',
			type:'post',
			data: formDataUpdate,
			contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
			processData: false, // NEEDED, DON'T OMIT THIS
			beforeSend : function() {
				
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
			success : function(data){
				clearInterval(progressInterval);
				$('.greenbar').css('left', '0%');
				$('.progressbarText').text('Done');
				var d = data;
				d = JSON.parse(d);
				console.log(d);
				
				form_edit.find('[name]').each(function(index,value){
					value.value = '';
				});
				
				formDataUpdate = new FormData();
				
				pictureUpdate.classList.remove('green');
				pictureUpdate.classList.remove('green');
			},
			error : function() {
				
			}
		});
		
	});
	
	fetchProduct.on('click',function(){
			//console.log("fetch product");
			
			var product_id_to_fetch = $(this).parent().parent().find("input#product_id_load").val();
			
			console.log(product_id_to_fetch);
			
			$.ajax({
				url:'/php/fetchProductInfoForAdmin.php',
				type:'post',
				data :{
					product_id : product_id_to_fetch
				},
				beforeSend : function(){
					
				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);
					
					form_edit.find('[name]').each(function(index,value){
						//console.log(value);
						if(value.getAttribute('name') == 'title' ){
							value.value = d.title;
						} else if(value.getAttribute('name') == 'brand' ){
							value.value = d.brand;
						} else if(value.getAttribute('name') == 'stock' ){
							value.value = d.stock;
						} else if(value.getAttribute('name') == 'category' ){
							value.value = d.category;
						} else if(value.getAttribute('name') == 'stock' ){
							value.value = d.stock;
						} else if(value.getAttribute('name') == 'price' ){
							value.value = d.price;
						} else if(value.getAttribute('name') == 'color' ){
							value.value = d.product_color;
						} else if(value.getAttribute('name') == 'description' ){
							value.value = d.description;
						} else if(value.getAttribute('name') == 'original' ){
							if(d.original == 'true'){
								value.checked = true;
							} else {
								value.checked = false;
							}
						}
					});
				},
				error : function() {
					
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

				$("#selectEditProduct").html(append_tbody);
			},
			error : function() {

			}
		});

	};

	onStart();

});