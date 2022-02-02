$(document).ready(function(){

	var savedList = $('#savedList');
	var containerTitle = $('.containerTitle');

	var userConfigurationRemain = $(".userConfigurationRemain");
	var basketNotificationButton = $(".basketNotificationButton");

	var snackBarMultiplyResult = $(".multiplyResult");
	var snackBar = $("#snackbar");
	var snackBar2 = $("#snackbar2");
	var snackBar3 = $("#snackbar3");

	var sizeBox = $('.sizeBox');

	var numberOfSwipers = 0;


	var start = 0;
	var startLoading = false;
	
	
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
	
	
	
	var letScrollDoSomeThing = false;
	var makeScrollDoSomeThing = function(){
	    setTimeout(function(){ 
	        letScrollDoSomeThing = true;
	    }, 500);
	}

	$(window).scroll(function(){
	    
	    if ( letScrollDoSomeThing === false ){
	        return false;
	    }
	    
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 340;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			onStartReturnSaved();
		}

		//console.log(startLoading);
		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});


	showSnackBar = function(){
		snackBar.addClass("show");
	};
	
	showSnackBar2 = function(){
		snackBar2.addClass("show");
	};

	showSnackBar3 = function(){
		snackBar3.addClass("show");
	};
	
	window.onclick = function(event) {
		snackBar.removeClass("show");
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





	
	printProductPictures = function(d){
		numberOfSwipers++;
		return `
		<div class="container_images">
		<style>
		.swiper-container${numberOfSwipers} {
			position : relative;
			width: 50%; /* dont write max-width or you will fucked up */
			height: 100%;
		  }
		  .swiper-slide {
			background-position: center;
			background-size: cover;
		  }
		  
		</style>
		<div class="swiper-container${numberOfSwipers}">
        <div class="swiper-wrapper">
		${d.map(function(row){
		return `
			<div class="swiper-slide" style="background-image:url('${row.file_destination}')"></div>
			`;
			}).join('')}
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<script>
		new Swiper('.swiper-container${numberOfSwipers}', {
			effect: 'cube',
			grabCursor: true,
			cubeEffect: {
			  shadow: false,
			  slideShadows: false,
			  shadowOffset: 20,
			  shadowScale: 0.94,
			},
			pagination: {
			  el: '.swiper-pagination',
			},
			navigation: {
			  nextEl: '.swiper-button-next',
			  prevEl: '.swiper-button-prev',
			},
			loop : true,
		  });
		</script>
		</div>
		`;
	}


	
	var displayDescription = function(description,color){
		var maxLength = 20;
		
		if( color.trim() !== ''  && color !== undefined && color !== null){
			return `<div></div>`;
		} else if( description.trim() === ''  || description === undefined || description === null){
			return `<div></div>`;
		} else {
			if ( description.length < maxLength){
				return description;
			} else {
				return '...'+description.substr(0,maxLength); 
			}
		}
	}

	var displayColor = function(color){
		return color;
	}

	var displayColorOrNot = function(color){
	    
	    //$.trim
		if( color.trim() === ''  || color === undefined || color === null){
			return `<div></div>`;
		} else {
			return `
			<div> : رنگ  </div>
			<div class="colorDiv" style="background-color:${displayColor(color)};"></div>
			`;
		}		
	}

	var displayBrand = function(brand){
		var maxLength = 20;
		if( brand.trim() === ''  || brand === undefined || brand === null){
			return `<div></div>`;
		} else {
			if ( brand.length < maxLength){
				return brand;
			} else {
				return '...'+brand.substr(0,maxLength); 
			}
		}
	}

	var displayTitle = function(title){
		var maxLength = 20;
		if( title.trim() === '' || title === undefined || title === null){
			return `<div></div>`;
		} else {
			if ( title.length < maxLength){
				return title;
			} else {
				return '...'+title.substr(0,maxLength); 
			}
		}
	}
	

	printProductData = function(d) {
		return `
		${ d.map(function(row){
			return `
			<div class="container">
			<div id="save_${row.product_id}" class="save">${ row.save_id !== null && row.save_id !== undefined ?  '<i class="fas fa-bookmark"></i>' : '<i class="far fa-bookmark"></i>' }</div>
			<h2 id="title_${row.product_id}" class="title">
				${displayTitle(row.title)}
			</h2>
			<div class="brand">
				<div>${displayBrand(row.brand)}</div>
				<div ${row.original === "true" ? '' : 'style="display:none;"' } class="showOriginal">اصل</div>
			</div>
			<div class="description">
				<div>${displayDescription(row.description,row.product_color)}</div>
			</div>
			<div class="color">
				${displayColorOrNot(row.product_color)}
			</div>
			<div class="priceDescription">
			<div> تومان  </div><div class="price"> ${row.price} </div><div> : قیمت </div>
			</div>
			<div class="BuyButtonContainer">
				<button id="${row.product_id}" class="buy checkLogin"><i class="fas fa-shopping-cart"></i><span>خرید</span>
				<span ${ (row.multiply !== null && row.multiply !== undefined) ? 'style="display:block;"' : 'style="display:none;"' } class="notificationNumber">${row.multiply}</span></button>
				<div class="countererContainer"><button class="counterer minusminus">-</button><div class="counterText">1</div><button class="counterer plusplus">+</button></div>
			</div>
			<div class="stockContainer">
				<div>&nbsp; : موجودی </div>
				<div>${row.stock}</div>
			</div>
		</div>
		`
		}).join('')}
		`;
	};





    var onStartReturnSaved  = function(){
		showLoadingBar();
		$.ajax({
			url:'/php/returnSavedProducts.php',
			type:'post',
			data:{
				phone : phone,
				sms   : sms,
				start : start,
			},
			beforeSend: function(){
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);

				var append_tbody;

				if(d.count === 0 && d.start === 0){
					append_tbody = `
					<div class="showEmptySavedBaskets">
					<div>
					کالایی را مارک <i class="far fa-bookmark"></i> نکردید
					</div>
					</div>
					`;

					startLoading = true;
				}
				else if(d.success !== false) {
					if(d.length > 0) {
						start += 10;
						startLoading = false;

						containerTitle.css('display','');
						//sizeBox.css('display','none');

						append_tbody = `
						${d.map(function (row) {
						return `
							<div data-aos="fade-up"
							data-aos-anchor-placement="top-bottom" class="card">
							${printProductPictures(row.pictures)}
							${printProductData(row.product)}
							</div>
								`
						}).join('')}
							`;
					} else {
						append_tbody = `
						<div class="finishMessage">
						<div>
						
						</div>
						</div>
						`;

						startLoading = true;
					}
				} 
				
				savedList.append(append_tbody);
				hideLoadingBar();
			},
			error : function(){
				hideLoadingBar();
			}
		});
		
	};
    


	$(document).on('click','i.fa-bookmark',function(){
		//console.log('save');
		var product_id = $(this).parent().attr('id');
		
		//console.log($(this));
		
		//console.log(product_id);
		if( product_id !== undefined )
		{
			var tempID = product_id.split("_");
			product_id = tempID[1];
			var thisProduct = $(this);

			$.ajax({
				url:'/php/saveProduct.php',
				type:'post',
				data:{
					product_id : product_id,
					phone : phone,
					sms   : sms
				},
				beforeSend: function(){
				},
				success : function(data){
					var d = data;
					d = JSON.parse(d);
					//console.log(d);

					if(d !== undefined){
						if(d.success === true){
							if(d.delete === true){
								thisProduct.removeClass('fas');
								thisProduct.addClass('far');
							} else if(d.insert === true){
								thisProduct.removeClass('far');
								thisProduct.addClass('fas');
							}
						}
					}
				},
				error : function(){
				}
			});
		}
	});



	$(document).on('click','h2',function(){

		
		var product_id = $(this).attr('id');
		var temp = product_id.split("_");
		product_id = temp[1];

		if(product_id !== undefined){
			window.location.href = `../products/${product_id}`;
		}
		

	});


	$(document).on('click','button.minusminus',function(){
		var father = $(this).parent().find("div.counterText");
		var number = Number(father.text());
		
		number--;
		if(number < 1){
			number = 1;
		} else if(number >= 99) {
			number = 99;
		}
		father.text( number );
	});
	
	$(document).on('click','button.plusplus',function(){
		var father = $(this).parent().find("div.counterText");
		var number = Number(father.text());
		
		number++;
		if(number < 1){
			number = 1;
		} else if(number >= 99) {
			number = 99;
		}
		father.text( number );
    });
    


	$(document).on('click','.buy',function(){
		if( localStorage.phone === undefined && localStorage.sms === undefined ) {
		} else {
			var father = $(this).parent().find("div.counterText");
			var counter = Number(father.text());
			
			var productId = $(this).attr('id');
			var thisNotification = $(this).find(".notificationNumber");
			//console.log(productId);
	
			$.ajax({
				url : '/php/addToBasket.php',
				type : 'post',
				data : {
					phone : phone,
					sms : sms ,
					productId : productId,
					counter : counter
				},
				beforeSend : function (){
	
				},
				success : function(data) {
					var d = data;
					d = JSON.parse(d);
					//console.log(d);
					
					if(d.counter === false){
						showSnackBar3();
					} else if( d.count_user === 0 ){
						
					} else if( d.stock_error === true){
						showSnackBar2();
					} else if(d.multiply !== null && d.multiply !== undefined ) {
						snackBarMultiplyResult.text(d.multiply);
						thisNotification.text(d.multiply);
						basketNotificationButton.text(d.numberOfOrdersInBasket);
		
						showSnackBar();
		
						updateHeaderStatus();
						
						//basketNotificationButton.css('display',''); // I move this to updateHeaderStatus function -> success
						thisNotification.css('display','');
					}
				},
				error : function () {
	
				}
			});
		}
    });
    
    
    
    var promise = new Promise(function(resolve, reject) { 
		resolve(onStartReturnSaved());
	}); 
		
	promise. 
	then(function (success) { 
        makeScrollDoSomeThing();
	}).
	catch(function (error) { 

	}); 


});