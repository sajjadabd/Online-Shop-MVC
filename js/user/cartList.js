$(document).ready(function(){

	var listOfBasketsContent = $("#listOfBasketsContent");
	var containerTitle = $('.containerTitle');
	var sizeBox = $('.sizeBox');


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
	    
	    if( letScrollDoSomeThing === false ){
	        return false;
	    } 
	    
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 340;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			onStartReturnBaskets();
		}

		//console.log(startLoading);
		//console.log(`scrollTop : ${scrollTop}`);
		//console.log(`difference : ${difference}`);
		//console.log(`documentHeight : ${documentHeight}`);
		//console.log(`windowHeight : ${windowHeight}`);
	});




    var listItemsInBasket = function(insideBasket){
		return `
		${insideBasket.map(function (row) {
		return `
			<div class="eachProductInBasket">
				<div class="showBasketStatus">
					( ${row.brand} ) ${row.title}
				</div>
				<div class="showBasketStatus">
					<div> &nbsp; : توضیحات </div>
					<div>${row.description}</div>
				</div>
				<div class="showBasketStatus">
					<div> &nbsp; : تعداد </div>
					<div>${row.multiply}</div>
				</div>
				<div class="showBasketStatus">
					<div> &nbsp; : قیمت واحد </div>
					<div>${row.price}</div>
				</div>
			</div>
			`
		}).join('')}
		`;
	}

	var detectColor = function(process){
		if(process === "1"){
			return `
			MediumSeaGreen
			`;
		} else {
			return `
			Orange
			`;
		}
	};

	var detectProcess = function(process){
		if(process === "1"){
			return `
			ارسال شده
			`;
		} else {
			return `
			در حال بررسی
			`;
		}
	};

	printTitleOfBasket = function(d){
		return `
		${d.map(function(row){
			return `
			<div class="basketTitle print">
				<div>تاریخ خرید</div><div>مبلغ کل</div><div>شماره خرید</div> 
			</div>
			<div class="basketDescription print">
				<div>${row.date}</div>
				<div class="BasketMainDescription">
				${Number(row.basket_price)+Number(row.basket_post_price)}
				</div>
				<div>${row.basket_number}</div>
			</div>
			<div class="operations">
				<div class="statusColor" style="background-color:${detectColor(row.process)}">
					<div> : وضعیت </div>
					<div class="status">${detectProcess(row.process)}</div>
				</div>
				<button id="basket_${row.basket_id}" class="printBasket"> دریافت فاکتور </button>
			</div>
			`;
		}).join('')}
		`;
	}


    var displayPostPrice = function(d){
        return `
        ${d.map(function(row){
            return `
            <div class="postPriceList">
                <div> &nbsp;  : هزینه ی ارسال  </div>
                <div class="exactPostPrice">
                    <div>  &nbsp; تومان</div>
                    <div>  &nbsp; ${row.basket_post_price}</div>
                </div>
            </div>
            `;
        }).join('')}
        `;
    }
	


	showBasketsToPage = function(d) {
		
		var append_tbody;
		
		
        if( start === 0 && d.length === 0 ){
            append_tbody = `
			<div class="showEmptyListBaskets">
			<div>
			شما تا به حال خریدی نداشتید
			</div>
			</div>
			`;
			startLoading = true;
        } else if( d.length === 0 ){

			append_tbody = `
			<div class="finishMessage">
			<div>
			
			</div>
			</div>
			`;
			/*
			append_tbody = `
			<div class="showEmptyListBaskets">
			<div>
			شما تا به حال خریدی نداشتید
			</div>
			</div>
			`;
			*/
			startLoading = true;
		} else {
			start += 10;

			containerTitle.css('display','');
			// reverse the array  without overwrite original array ==> .slice(0).reverse() 
			// use .reverse() to reverse original array
			append_tbody = `
			${d.map(function (row) { 
				return `
				<div class="completeListBasketContainer">
					${printTitleOfBasket(row.basket)}
					<div class="basketListTitle print">لیست وسایل</div>
					<div class="allTheThingsInBasket print">${listItemsInBasket(row.inside_basket)}</div>
				    <div class="postPrice print">${displayPostPrice(row.basket)}</div>
				</div>
					`
			}).join('')}
			`;
			
			startLoading = false;
		}
		
		listOfBasketsContent.append(append_tbody);
	};
	

	var onStartReturnBaskets = function(){

		
		$.ajax({
			url  :'/php/returnBaskets.php',
			type :'post',
			data : {
				phone : phone,
				sms : sms,
				start : start
			},
			beforeSend: function(){
				showLoadingBar();
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				//console.log(d);
				
				showBasketsToPage(d);
				
				hideLoadingBar();
			},
			error : function(){
				
			}
		});
		
	};
    
    
    
    var promise = new Promise(function(resolve, reject) { 
		resolve(onStartReturnBaskets());
	}); 
		
	promise. 
	then(function (success) { 
        makeScrollDoSomeThing();
	}).
	catch(function (error) { 

	}); 

});