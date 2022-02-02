$(document).ready(function(){

    var sidenav_ul = $("#sidenav_ul");
	var products_tbody    = $("#content");
	
	var snackBarMultiplyResult = $(".multiplyResult");
	var snackBar = $("#snackbar");
	var snackBar2 = $("#snackbar2");
	var snackBar3 = $("#snackbar3");

	var numberOfSwipers = 0;

	var category_id = 0;
	var category_name;

	
	var searchTerm = '';
	var weAreInSearch = false;
	

	var start = 0;
	var startLoading = false;

	var noProductFound = false;
	
	//var backToTop = $('#backToTop');
	
	var phone = '';
	var sms = '';
	
	if (typeof(Storage) !== "undefined") {
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
	
	
	var backToTop = $('#backToTop');
	
	var letScrollDoSomeThing = false;
	var makeScrollDoSomeThing = function(){
	    setTimeout(function(){ 
	        letScrollDoSomeThing = true;
	    }, 1000);
	}
	
	
	$(window).scroll(function(){
	    
	    
	    if(letScrollDoSomeThing === false)
	        return false;
	    
		var scrollTop = $(window).scrollTop() ;
		var documentHeight = $(document).height();
		var windowHeight = $(window).height()

		var difference = documentHeight - windowHeight;
		var offset = 600;
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		//console.log('scrollTop : ' + scrollTop);
		//console.log('difference : ' + difference);

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			if( category_id !== 0 &&  category_id !== undefined){
				loadCategoryResults();
				//console.log('loadCategoryResults');
				//console.log('start : ' + start);
			} else if ( weAreInSearch === true ){
				searchFunction(searchTerm);
			} else if( category_id === 0 || category_id === undefined ) {
				getProducts();
			}
			
		}

		//console.log(startLoading);

		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
		
		/*
		//backToTop
		var attr = backToTop.css('display');
        
        if( $(window).scrollTop() > $(window).height() ){
            if( attr == 'none' )
                backToTop.fadeIn("slow");
        } else {
            if ( attr == 'flex' )
                backToTop.fadeOut("slow");
        }
        */
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

		if (event.target == modalForDelete) {
			modalForDelete.style.display = "none";
		}
		
		
		
		// var clickOnCog = false;
		// var bodyEl = document.body;
		// //console.log(event.target);
		
		// event.target.classList.forEach(function(value){
		// 	if( value === 'fa-cog' || value === 'menu-button' ){
		// 		clickOnCog = true;
		// 	}
		// });
		
		// if( clickOnCog === false ) {
		// 	classie.remove( bodyEl, 'show-menu' );
		// }
		
	}
	
	
	$('a#logoff').on('click',function(e){
		
	   localStorage.removeItem('phone');
	   localStorage.removeItem('sms');
	   
	   deleteCookie('phone');
	   deleteCookie('sms');
	   
	   //console.log('delete storage');
	   //e.preventDefault();
	   //window.location.href = '../../home/logout';

	});

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

    //This is for attemp to buy but user not logged in
    $(document).on('click','.buy.checkLogin',function(){

        if( phone === undefined || sms === undefined ){
            modal.style.display = "block";
        } else if(phone === null || sms === null){
			modal.style.display = "block";
		} else {

        }
	});

	//This is for attemp to go to cart
    $('a#basket_near_search').on('click',function(e){
		e.preventDefault();

        if( phone === undefined || sms === undefined ){
            modal.style.display = "block";
        } else if(phone === null || sms === null){
			modal.style.display = "block";
		} else {
			window.location.href = $(this).attr('href');
		}
		
		return false;
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
    


    
    $(document).on('click','i.fa-bookmark',function(){
		//console.log('save');
		var product_id = $(this).parent().attr('id');
		
		//console.log($(this));
		//console.log(product_id);
		if(product_id !== undefined)
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


    var loadSideNav = function() {
		$.ajax({
			url:'/php/loadSideNav.php',
			type:'post',
			data:{
			},
			beforeSend:function(){
			},
			success : function(data){
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				var append_tbody = `
					${d.map(function (row) {
					return `
					<li><a id="category_${row.category_id}" title="${row.category_name} _ فروشگاه لوازم آرایشی نکا بیوتی" href="#">${row.category_name}</a></li>
					`
					}).join('')}
					`;
	
				sidenav_ul.html(append_tbody);
				
			},
			error : function() {
				
			}
		});
	};
	
	var booleanForLoadOnScrollForCategory = true;

    var tryToFixLoadOnScrollBugForCategory = function(){
        setTimeout(function(){ 
            booleanForLoadOnScrollForCategory = true;
        }, 100);
    }
	
	loadCategoryResults = function() {
	    
	    if( booleanForLoadOnScrollForCategory === false ){
	        return false;
	    }
	    
	    booleanForLoadOnScrollForCategory = false;
	    tryToFixLoadOnScrollBugForCategory();

		if(category_id !== undefined){
			//console.log(category_id);
			$.ajax({
				url:'/php/returnCategoryResults.php',
				type:'post',
				data:{
					category_id : category_id,
					phone : phone,
					sms   : sms,
					start : start,
				},
				beforeSend: function(){
					showLoadingBar();
				},
				success: function(data){

					var d = data;
					d = JSON.parse(d);
					//console.log(d);
					
					
					var promiseForLoadCategory = new Promise(function(resolve, reject) { 
                		resolve($('div#categoryShow').text(category_name));
                	}); 
                	
                	promiseForLoadCategory. 
                	then(function (success) { 
                		$('input#search').val('');
                	}).
                	then(function(success){
                	    hideLoadingBar();
                	}).
                	then(function(success){
                	    showProductsToPage(d);
                	}).
                	then(function(success){
                	    makeScrollDoSomeThing();
                	}).
                	catch(function (error) { 
                
                	}); 

				},
				error: function(){
					hideLoadingBar();
					//closeSideNav();
				}
			});
		}
	}

    $(document).on('click','a',function(){
        
        letScrollDoSomething = false;//prevent category loadOnScroll Bug
        
		var category_temp_id = $(this).attr('id');
		if(category_temp_id === "close"){
		    //console.log('hit it');
		    closeSideNav();
		    makeScrollDoSomeThing();
		    return false;
		}
		category_name = $(this).text();
		//console.log(category_temp_id);
		if( category_temp_id !== undefined ){
		    var temp = category_temp_id.split("_");
    		category_id = temp[1];
    		//console.log(category_id);
    		if( category_id !== undefined ){
    		    start = 0;
        		weAreInSearch = false;
        		products_tbody.html('');
        		loadCategoryResults();
        		
        		closeSideNav();
        		return false;
    		}
    		closeSideNav();
        	//return false;
		}
		
		

	});




    var sendSearchRequest = false;
	var inputSearch = $("input#search");
	var isThereAnotherSearch = false; 
	var prev_value = '';

	var searchFunction = function(searchTerm){
			//console.log('start search');

			$.ajax({
			url:'/php/search.php',
			type:'post',
			data:{
				searchTerm : searchTerm,
				phone : phone,
				sms : sms,
				start : start,
			},
			beforeSend: function() {
				showLoadingBar();
			},
			success : function(data) {

				
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				if( d.length === 0 && start === 0 ){
					noProductFound = true;
					products_tbody.html('');
					append_tbody = `
					<div class="showEmptySearchResults">
					<div>
					کالایی پیدا نشد
					</div>
					</div>
					`;
					startLoading = true;
					products_tbody.append(append_tbody);
				} else {
					if(noProductFound === true){
						noProductFound = false;
						products_tbody.html('');
						
					}
					
					showProductsToPage(d);
				}
				

				sendSearchRequest = false;
				if(isThereAnotherSearch == true){
					isThereAnotherSearch = false;
					sendSearchRequest = true;
					var searchTerm = inputSearch.val();
					searchTerm = $.trim(searchTerm);
					searchFunction(searchTerm);
				}
				
				$('div#categoryShow').text('. . .');
				hideLoadingBar();
			},
			error : function() {
			    
				hideLoadingBar();
			}
		});
	}
	

    var inputKeyUpEvent = function(){
        start = 0;
		category_id = 0;
		weAreInSearch = true;

		searchTerm = inputSearch.val();
		searchTerm = $.trim(searchTerm);

        
		if(searchTerm === prev_value){
		    //console.log(searchTerm);
			return false;
		}
		
		if( searchTerm === '' ){
			weAreInSearch = false;
			products_tbody.html('');
			getProducts();
			return false;
		}
		
		products_tbody.html('');
		if( sendSearchRequest == false ){
			sendSearchRequest = true;
			searchFunction(searchTerm);
		} else {
			isThereAnotherSearch = true;
		}

		prev_value = searchTerm;
    }
    
    var searchTimeOut;

    inputSearch.keyup(function(){
        clearTimeout(searchTimeOut);
        searchTimeOut = setTimeout(function(){ 
            inputKeyUpEvent();
        }, 1000);
	});
	

	//<img class="shopImage"  src="${row.file_destination}" alt="${row.picture_alt}">
	

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

	/*
	$(document).on('click','h2',function(){

		
		var product_id = $(this).attr('id');
		var temp = product_id.split("_");
		product_id = temp[1];

		if(product_id !== undefined){
			window.location.href = `../products/${product_id}`;
		}		
	});
	*/
	
	// <h2 id="title_${row.product_id}" class="title">
	// </h2>

	printProductData = function(d) {
		return `
		${ d.map(function(row){
			return `
			<div class="container">
			<div id="save_${row.product_id}" class="save">${ row.save_id !== null && row.save_id !== undefined ?  '<i class="fas fa-bookmark"></i>' : '<i class="far fa-bookmark"></i>' }</div>
			<a class="productTitle" href="../products/${row.product_id}" title="${row.title} ( ${row.brand} ) _ فروشگاه لوازم آرایشی نکا بیوتی">
				${displayTitle(row.title)}
			</a>
			<div class="brand">
				<div title="${row.title} ( ${row.brand} )  _ فروشگاه لوازم آرایشی نکا بیوتی">${displayBrand(row.brand)}</div>
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



    showProductsToPage = function(d) {
        
        if(start === 0){ // this is the amazing part that fix category load on scroll bug
	        products_tbody.html('');
	    }
				    
				    
		var append_tbody;
		if(d.length === 0){
			append_tbody = `
			<div class="finishMessage">
				<div>
				
				</div>
			</div>
			`;
			startLoading = true;
		} else {
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
			start += 10;
			startLoading = false;
		}

		products_tbody.append(append_tbody);
	};


	checkForDisplayCircleMenu = function(){

		$.ajax({
			url : '/php/checkUserLogin.php',
			type: 'post',
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

				if(d.success !== undefined){
					if(d.success === true){
						$('.myCircleMenu').css('visibility','visible');
						//console.log('everything works well!!');
						if (typeof(Storage) !== "undefined") {
							//localStorage.phone = d.phone;
							//localStorage.sms = d.sms;
						}
						//setCookie('phone',d.phone, 356); // set cookie for 365 days
						//setCookie('sms'  ,d.sms  , 356);
						
					} else {
						if (typeof(Storage) !== "undefined") {
							localStorage.removeItem("phone");
							localStorage.removeItem("sms");
						}
						deleteCookie('phone');
						deleteCookie('sms');
						phone = null; // never remove this line
						sms = null; // never remove this line
					}
				} else {
				    if (typeof(Storage) !== "undefined") {
						//localStorage.removeItem("phone");
						//localStorage.removeItem("sms");
					}
					//deleteCookie('phone');
					//deleteCookie('sms');
					//phone = null;// never remove this line
					//sms = null;// never remove this line
				}
			},
			error : function() {

			}
		});
	}

    getProducts = function() {

		$.ajax({
			url: '/php/getProducts.php',
			type: 'post',
			data: {
				phone : phone,
				sms : sms,
				start : start,
			},
			beforeSend: function () {
				showLoadingBar();
			},
			success: function (data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);

				if( d !== undefined ) {				
					showProductsToPage(d);
				} 

				hideLoadingBar();
			},
			error: function () {
				loading.css("display","none");
				//console.log("Error Happens On Ajax!");
				hideLoadingBar();
			}
		});
    };
	
	
	var promise = new Promise(function(resolve, reject) { 
		resolve(checkForDisplayCircleMenu());
	}); 
	
	promise. 
	then(function (success) { 
		getProducts();
	}). 
	then(function(success){
		loadSideNav();
	}).
	then(function(success){
	    makeScrollDoSomeThing();
	}
	).
	catch(function (error) { 

	}); 

	
	//updateHeaderStatus();


});