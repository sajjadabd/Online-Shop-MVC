$(document).ready(function(){

    var SubmitBasketButton = $("#SubmitBasketButton");
    var SubmitBasketInfo = $("#SubmitBasketInfo");
	var MyBasketContent    = $("#MyBasketContent");

	var factor_table = $('#factor_table');
	
	var snackBar3 = $("#snackbar3");
	var snackBar2 = $('#snackbar2');

    var modalForDeleteItem = $("#myModal-delete-item");
    var acceptDeleteItem   = $("button#deleteItemButton");

	var userConfigurationRemain = $(".userConfigurationRemain");
	var basketNotificationButton = $(".basketNotificationButton");

	var loading2 = $('#loading2');
	
	var basketIsEmpty = false;

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



	showSnackBar2 = function(){
		snackBar2.addClass("show");
	};

	showSnackBar3 = function(){
		snackBar3.addClass("show");
	};


	showLoadingBar2 = function() {
		loading2.css('display','');
	};

	hideLoadingBar2 = function() {
		loading2.css('display','none');
	};


	showSubmitBasketButton = function(){
		SubmitBasketButton.css('display','');
	};

	hideSubmitBasketButton = function() {
		SubmitBasketButton.css('display','none');
	};
	
	
	window.onclick = function(event) {
		//snackBar.removeClass("show");
		snackBar2.removeClass("show");
		snackBar3.removeClass("show");
	}
	
	
	var letScrollDoSomeThing = false;
	var makeScrollDoSomeThing = function(){
	    setTimeout(function(){ 
	        letScrollDoSomeThing = true;
	    }, 500);
	}
	

	$(window).scroll(function(){
	    
	    if( letScrollDoSomeThing === false )
	        return false;
	    
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 340;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			updateMyBasket();
		}

		//console.log(startLoading);

		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});



	
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
					//SubmitBasketButton.css('display','none');
					
					SubmitBasketInfo.animate({
						opacity: 0
						}, 1000, function() {
							SubmitBasketInfo.css('display', 'none');
						});

					if(basketIsEmpty === false){
						basketIsEmpty = true;
						//updateMyBasket();
					}
					
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
			width: 100%; /* dont write max-width or you will fucked up */
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


	printProductData = function(d){
		return `
		${d.map(function(row){ 
			return `
			<div class="container_Basket">
				<div id="cart_${row.product_id}" class="card_Basket_Delete">
					<i class="fas fa-minus-square"></i>
					<i class="fas fa-plus-square"></i>
					<i class="fas fa-window-close"></i>
				</div>
				<div></div>
				<div class="title_Basket">${row.title}</div>
				<div class="brand_Basket">
					<div>${row.brand}</div>
					<div ${row.original === "true" ? '' : 'style="display:none;"' } class="showOriginal">اصل</div>
				</div>
				<div class="price_Basket">
					<div>${row.price}</div>
					<div>&nbsp; : قیمت</div>
				</div>
				<div class="multiply_Basket"><span class="multiply_number">${row.multiply}</span> : تعداد</div>
				<div class="multiply_Basket"><span class="price_number">${row.multiply*row.price}</span> : قیمت کل</div>
			</div>
			`
		}).join('')}
	`;
	};


	var printInsideBasketForFactorTable = function(d){
		return `
		${d.map(function(row){
			return `
			<tr>
				<td>(${row.brand}) ${row.title}</td>
				<td>${row.multiply}</td>
				<td>${row.price}</td>
				<td>${row.price*row.multiply}</td>
			</tr>
			`;
		}).join('')}
		`;
	}
	
	
	var checkFreeOrNot = function(price){
        return `
	    <div>${price}</div>
		<div>تومان</div>
        `;
	}
	
	var checkFreeOrNotForFinalPrice = function(price){
        return `
        <div>${price}</div>
		<div>تومان</div>
        `;
	}


	var printFactorList = function(d){
		factorList = `
		${d.map(function(row){
			return `
			${printInsideBasketForFactorTable(row.product)}
			`;
		}).join('')}
		`;

		factorList += `
		<tr>
			<td colspan="3">هزینه ی بسته بندی</td>
			<td colspan="2">رایگان</td>
		</tr>
		<tr>
			<td colspan="3">هزینه ی ارسال</td>
			<td colspan="2">
			<div class="tellTheTruePrice">
			    ${ checkFreeOrNot(d[0].basket_post_price) }
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="3"> مبلغ کل </td>
			<td colspan="2">
			<div class="tellTheTruePrice">
			    ${checkFreeOrNotForFinalPrice(d[0].total_price)}
			</div>
		</td>
		</tr>
		`;
		factor_table.html(factorList);
	}


	var printBasketlist = function(d){
		append_tbody = `
		${d.map(function (row) {
		return `
		<div class="card_Basket">
			${printProductPictures(row.pictures)}
			${printProductData(row.product)}
		</div>
		`
		}).join('')}
		`;
		MyBasketContent.append(append_tbody);
	}

	var updateMyFactorList = function(){
		
		data = {
			phone : phone,
			sms : sms,
		};
		
		$.ajax({
			url:  '/php/returnCartFactor.php',
			type: 'post',
			data: data,
			beforeSend: function(){
				//showLoadingBar();
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				//console.log(d.length);
	
				if( d.count === 0 && d.start === 0 ) {
	
				} else {
						
					if ( d.length > 0 ){
						SubmitBasketInfo.css('display','');
						printFactorList(d);					
					} else {
						
					}
				}
	
				hideLoadingBar();
			},
			error: function(){
				hideLoadingBar();
			}
		});
	}
	
	var booleanForLoadOnScrollForCart = true;

    var tryToFixLoadOnScrollBugForCart = function(){
        setTimeout(function(){ 
            booleanForLoadOnScrollForCart = true;
        }, 1000);
    }

    var updateMyBasket = function() {
        
        if(booleanForLoadOnScrollForCart === false){
            return false;
        }
        
        booleanForLoadOnScrollForCart = false;
	    tryToFixLoadOnScrollBugForCart();
		
		data = {
			phone : phone,
			sms : sms,
			start : start,
		};
		
		$.ajax({
			url:  '/php/returnCart.php',
			type: 'post',
			data: data,
			beforeSend: function(){
				showLoadingBar();
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				//console.log(d.length);
				

				
				if( d.count === 0 && d.start === 0 ) {
					SubmitBasketInfo.css('display','none');
					append_tbody = `
					<div class="showEmptyBasket">
						<div>
							سبد خرید شما خالی است
						</div>
					</div>
					`;
					MyBasketContent.append(append_tbody);

					startLoading = true;
				} else {
					
					
					if ( d.length > 0 ){
						start += 10;

						SubmitBasketInfo.css('display','');
						
						printBasketlist(d);

						//printFactorList(d);
						
						startLoading = false;
					} else {
						append_tbody = `
						<div class="finishMessage">
							<div>
							
							</div>
						</div>
						`;
						MyBasketContent.append(append_tbody);

						startLoading = true;
					}
				}
				
				updateHeaderStatus();
				hideLoadingBar();
			},
			error: function(){
				hideLoadingBar();
			}
		});
		
	};
	
	
	
	
	
	var finalSubmitBasket = function(){
		$.ajax({
			url:'/php/PaymentBasket.php',
			type:'post',
			data: {
				phone : phone,
				sms : sms
			},
			beforeSend : function() {
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);

				if( d.success !== undefined ){
					if( d.success === true){
						

						window.location.href = d.url;
						/*
						snackBar3.addClass("show");
						//updateMyBasket();
						MyBasketContent.find("div.card_Basket").each(function(index,value){
							$(this).fadeOut("slow");
						});
						
						MyBasketContent.parent().find("div.SubmitBasket").each(function(index,value){
							$(this).fadeOut("slow");
						});
		
						Swal.fire(
							'',
							'<div class="fontFarsi">خرید شما با موفقیت انجام شد</div>',
							'success'
						  )
						*/

						//hideLoadingBar2();
						//showSubmitBasketButton();
					}
				} else {
					hideLoadingBar2();
					showSubmitBasketButton();
				}
				
				updateHeaderStatus();
			},
			error : function(){
				hideLoadingBar2();
				showSubmitBasketButton();
			}
		});
	}
    
	SubmitBasketButton.on('click',function(){
		$.ajax({
			url : '/php/returnHeaderStatus.php',
			type : 'post',
			data : {
				phone : phone ,
				sms : sms
			},
			beforeSend : function() {
				hideSubmitBasketButton();
				showLoadingBar2();
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);

				if(d.configNumber === 0){
					finalSubmitBasket();
				// 	Swal.fire(
				// 		'',
				// 		`<div class="fontFarsi">
				// 		فعلاً قابلیت خرید کنسل شده است
				// 		</div>
				// 		<div class="fontFarsi">
				// 		<a href="../index">
				// 		فروشگاه نکا بیوتی
				// 		</a>
				// 		</div>`,
				// 		'error'
				// 	  )
				// 	hideLoadingBar2();
				// 	showSubmitBasketButton();
					
				} else {
					Swal.fire(
						'',
						'<div class="fontFarsi">لطفاً اطلاعات شخصی خود را تکمیل کنید</div><div class="fontFarsi"><a href="../userInfo">صفحه ی اطلاعات شخصی</a></div>',
						'error'
					  )

					hideLoadingBar2();
					showSubmitBasketButton();
				}

			},
			error : function(){
				hideLoadingBar2();
				showSubmitBasketButton();
			}
		});
		
	});



    var currentDeleteItem = '';
	var parentDeleteItem = '';
	
	acceptDeleteItem.on('click',function(){
	    
		start = 0;

		$.ajax({
			url:'/php/deleteItemFromBasket.php',
			type:'post',
			data:{
				phone : phone,
				sms : sms,
				deleteItemId : currentDeleteItem
			},
			beforeSend: function(){
			},
			success : function(data){
				var d = data ;
				d = JSON.parse(d);
				//console.log(d);

				var promiseForDelete = new Promise(function(resolve, reject) { 
					resolve(modalForDeleteItem.css('display','none'));
				}); 
					
				promiseForDelete. 
				then(function (success) { 
					parentDeleteItem.fadeOut("slow")
				}).
				then(function(success){
					updateHeaderStatus();
				}).
				then(function(success){
					updateMyFactorList();
				}).
				then(function(success){
					start = 0;
					MyBasketContent.html('');
					updateMyBasket();
				}).
				catch(function (error) { 
			
				}); 
				;
				;

				
				
				//MyBasketContent.html('');
				
			},
			error : function(){
			}
		});
		
	});
	
	
	$(document).on('click','span.close-delete-item',function(){
        modalForDeleteItem.css('display','none');
	});
    
    
    
	$(document).on('click','i.fa-window-close',function(){
		parentDeleteItem = $(this).parent().parent().parent();
		//console.log(parentDeleteItem);
		currentDeleteItem = $(this).parent().attr('id');
		var tempID = currentDeleteItem.split("_");
		currentDeleteItem = tempID[1];
        modalForDeleteItem.css('display','block');
    });
    



    changeItemInBasket = function(product_id, changer,changeSpan,changeSpanPrice){
		
		
		$.ajax({
			url:'/php/plusItemInBasket.php',
			type:'post',
			data :{
				phone : phone,
				sms : sms ,
				product_id : product_id,
				changer : changer
			},
			beforeSend : function(){
				
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				if(d.stock_error === true){
					showSnackBar2();
				} else {
					changeSpan.text(d.multiply);
					changeSpanPrice.text(d.price);
					
					updateHeaderStatus();
					updateMyFactorList();
				}
				
			},
			error : function() {
				
			}
		});
	}
	
	
	
	var parentPlusItem;
	var currentPlusProductID;
	
	$(document).on('click','i.fa-plus-square',function(){
		parentPlusItem = $(this).parent().parent();
		//console.log(parentPlusItem);
		currentPlusProductID = $(this).parent().attr('id');
		var tempID = currentPlusProductID.split("_");
		currentPlusProductID = tempID[1]
        //console.log(currentPlusProductID);
		
		
		var changeSpan = parentPlusItem.find("span.multiply_number");
		var changeSpanPrice = parentPlusItem.find("span.price_number");
		//console.log(changeSpan);
		
		var changer = 1;
		changeItemInBasket(currentPlusProductID,changer,changeSpan,changeSpanPrice);
	});
	
	var parentMinusItem;
	var currentMinusProductID;
	
	$(document).on('click','i.fa-minus-square',function(){
		parentMinusItem = $(this).parent().parent();
		//console.log(parentMinusItem);
		currentMinusProductID = $(this).parent().attr('id');
		var tempID = currentMinusProductID.split("_");
		currentMinusProductID = tempID[1]
        //console.log(currentMinusProductID);
		
		var changeSpan = parentMinusItem.find("span.multiply_number");
		var changeSpanPrice = parentMinusItem.find("span.price_number");
		//console.log(changeSpan);
		
		var changer = -1;
		changeItemInBasket(currentMinusProductID,changer,changeSpan,changeSpanPrice);
	});
	
	
	var promise = new Promise(function(resolve, reject) { 
		resolve(updateMyBasket());
	}); 
		
	promise. 
	then(function (success) { 
		updateMyFactorList();
	}).
	then(function(success){
        makeScrollDoSomeThing();
    }).
	catch(function (error) { 

	}); 
	

	

});