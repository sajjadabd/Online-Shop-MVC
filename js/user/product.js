$(document).ready(function(){
    var product_id = $('#product').text();
    product_id = $.trim(product_id);
    product_id = Number(product_id);

    var product_result = $('#product_result');
    var entranceButton = $("#entranceButton");

    var phone = localStorage.phone;
    var sms = localStorage.sms;

    var snackBarMultiplyResult = $(".multiplyResult");
	var snackBar = $("#snackbar");
	var snackBar2 = $("#snackbar2");
	var snackBar3 = $("#snackbar3");

    //console.log(product_id);
	
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
	


    entranceButton.on('click',function(){
        window.location.href = "../../login/";
	});
    
    //This is for attemp to buy but user not logged in
    $(document).on('click','.buy.checkLogin',function(){
        if( localStorage.phone === undefined || localStorage.sms === undefined ){
            modal.style.display = "block";
        } else {

        }
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
					} if(d.multiply !== null && d.multiply !== undefined ) {
						snackBarMultiplyResult.text(d.multiply);
						thisNotification.text(d.multiply);
						//basketNotificationButton.text(d.numberOfOrdersInBasket);
		
						showSnackBar();
		
						//updateHeaderStatus();
						
						//basketNotificationButton.css('display',''); // I move this to updateHeaderStatus function -> success
						thisNotification.css('display','');
					}
				},
				error : function () {
	
				}
			});
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
	

	var displayDescription = function(description){
		if(description === ''  || description === undefined || description === null){
			return `ندارد`;
		} else {
			return `${description}`;
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

    var printProductData = function(d){
        return `
        ${d.map(function(row){
            return `
            <div class="product_Card">
            <div class="product_Container">
                <h2 id="title_${row.product_id}" class="title">${row.title}</h2>
                <div class="brand">
                    <div>${row.brand}</div>
                    <div ${row.original === "true" ? '' : 'style="display:none;"' } class="showOriginal">اصل</div>
				</div>
				<div class="description">
                    <div>${displayDescription(row.description)}</div>
                    <div> &nbsp; : توضیحات </div>
				</div>
				<div class="color">
					${displayColorOrNot(row.product_color)}
				</div>
                <div class="priceDescription">
                
                    <div> تومان  </div>
                    <div class="price"> ${row.price} </div>
                    <div> : قیمت </div>

                </div>
                <div class="BuyButtonContainer">
                    <button id="${row.product_id}" class="buy checkLogin"><i class="fas fa-shopping-cart"></i><span>خرید</span>
                    <span ${ (row.multiply !== null && row.multiply !== undefined) ? 'style="display:block;"' : 'style="display:none;"' } class="notificationNumber">${row.multiply}</span></button>
                    <div class="countererContainer"><button class="counterer minusminus">-</button><div class="counterText">1</div><button class="counterer plusplus">+</button></div>
                </div>
            </div>
            </div>
            `;
        }).join('')}
        `;
    };

    var printPictures = function(d){
        return `
		<style>
		.swiper-container {
		    margin : auto;
		    margin-top : 50px;
			width  : 600px;
			height : 600px;
			
        }
          
        .swiper-wrapper {
            width  : 100%;
        }
		  
		.swiper-slide {
			
			background-position: center;
			background-size: cover;
			object-fit: fill;

		}

		@media only screen and (max-width: 900px) {
			.swiper-container {
				width  : 400px;
				height : 400px;
			}
		}

		@media only screen and (max-width: 700px) {
			.swiper-container {
				width  : 300px;
				height : 300px;
			}
		}

		@media only screen and (max-width: 500px) {
			.swiper-container {
				width  : 250px;
				height : 250px;
			}
		}

		  
		</style>
		<div class="swiper-container">
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
		new Swiper('.swiper-container', {
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
        `;
    };

    var showProductToPage = function(d){
        
        var append_tbody = `
        ${d.map(function(row){
            return `
            ${printProductData(row.product)}
            ${printPictures(row.pictures)}
            `;
        }).join('')}
        `;

        //console.log(append_tbody);

        product_result.append(append_tbody);
    };

    $.ajax({
        url:'/php/returnSpecificProduct.php',
        type:'post',
        data:{
            phone : phone,
            sms : sms,
            product_id : product_id
        },
        beforeSend : function(){

        },
        success : function(data) {
            var d = data;
            d = JSON.parse(d);
            console.log(d);

            showProductToPage(d);
        },
        error : function() {

        }
    });
});