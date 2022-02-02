$(document).ready(function(){

    var showBaskets    = $("#showBaskets");
	var baskets_tbody = $("#baskets_tbody");

	var start = 0;
	var startLoading = false;

	var weAreInSearch = false;
	var searchTerm = '';


	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop() ;
		var difference = $(document).height() - $(window).height();
		//var documentHeight = $(document).height();
		//var windowHeight = $(window).height();
		var offset = 250;

		if( (scrollTop > difference - offset) && startLoading == false ){
			startLoading = true;
			
			if( weAreInSearch === true){
				searchBasketsFunction(searchTerm);
			} else {
				showBaskets();
			}
		}
	});


	
	$(document).on('click','i.fa-check-square',function(){
		//console.log("Basket Processed");
		var parent = $(this).parent().attr('id');
		var temp = parent.split('_');
		var basket_id = temp[1];
		console.log(basket_id);
		
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'dodgerblue',
			cancelButtonColor: 'red',
			confirmButtonText: 'Yes, Process it!'
		  }).then((result) => {
			console.log(result.value);
			if (result.value) {
			
			  $.ajax({
				  url : '/php/processBasket.php',
				  type : 'post',
				  data : {
					basket_id : basket_id
				  },
				  beforeSend : function(){

				  },
				  success : function(data){
					var d = data;
					d = JSON.parse(d);
					console.log(d);

					if ( d.success === true ){
						Swal.fire(
							'Basket Processed',
							'',
							'success'
						  )
					}
				  },
				  error : function(){

				  }
			  });
			}
		  })
    });
	
	// <div class="BasketMainDescriptionForAdmin"></div>

    var listItemsInBasketForAdmin = function(insideBasket){
		return `
			${insideBasket.map(function (row) {
			return `
				<div class="eachProductInBasketForAdmin">
					<div class="BasketMainTitleForAdmin"> ( ${row.brand} ) ${row.title}</div>
					
					<div class="showBasketStatusForAdmin">
						<div> &nbsp; : توضیحات </div>
						<div>${row.description}</div>
					</div>
					
					<div class="showBasketStatusForAdmin">
						<div> &nbsp; : تعداد </div>
						<div>${row.multiply}</div>
					</div>

					<div class="showBasketStatusForAdmin">
						<div> &nbsp; : قیمت واحد </div>
						<div>${row.price}</div>
					</div>
				</div>
				`
		}).join('')}
			`;
	}
	


	eachBasketTitle = function(d){
		return `
		${d.map(function(row){
			return `
			<tr ${checkProcessAndBackground(row.process)}>
				<td>basket_id</td>
				<td>user_id</td>
				<td>-------date-------</td>
				<td>price</td>
				<td>process</td>
				<td>payment</td>
				<td>regret</td>
				<td>do?</td>
			</tr>
			<tr ${checkProcessAndBackground(row.process)}>
				<td>${row.basket_id}</td>
				<td>${row.user_id}</td>
				<td>${row.date}</td>
				<td>${Number(row.basket_price) + Number(row.basket_post_price)}</td>
				<td>${row.process}</td>
				<td>${row.payment_check}</td>
				<td>${row.customer_regret}</td>
				<td id="process_${row.basket_id}"><i class="fas fa-check-square"></i></td>
			</tr>
			`;
		}).join('')}
		`;
	}

	var printBasketHeader = function(d){
		return `
		${d.map(function(row){
			return `
			
			<div class="headerTitle">
				<div>شماره خرید</div>
				<div>شماره تماس</div>
				<div>مبلغ کل</div>
				<div>تاریخ خرید</div>
			</div>
			<div class="headerWrapper">
				<div>${row.basket_number}</div>
				<div>${row.phone}</div>
				<div>${Number(row.basket_price) + Number(row.basket_post_price)}</div>
				<div>${row.date}</div>
			</div>

			`;
		}).join('')}
		`;
	};

	var checkProcessAndBackground = function(process){
		if( process == 1 ){
			return `
			style="background-color:rgba(128, 214, 128,.4);"
			`;
		} else {
			return `
			style="background-color:rgba(154, 184, 188,.4);"
			`;
		}
	}

	var printUserInformation = function(d){
		return `
		${d.map(function(row){
			return `
			<div class="eachProductInBasketForAdmin">

                <div class="showBasketStatusForAdmin">
					<div> &nbsp; : نام کاربری </div>
					<div>${row.username}</div>
				</div>
				
				<div class="showBasketStatusForAdmin">
					<div> &nbsp; : کد پستی </div>
					<div>${row.zipcode}</div>
				</div>

				<div class="showBasketStatusForAdmin">
					<div> &nbsp; : آدرس </div>
					<div>${row.address}</div>
				</div>

			</div>
			`
		}).join('')}
		`;
	}
	
	
	var printPostPrice = function(d){
	    return `
	    ${d.map(function(row){
	        return `
	        <div class="showBasketStatusForAdmin">
    	        <div> : هزینه ی ارسال </div>
    	        <div>${row.basket_post_price}</div>
    	    </div>
	        `
	    }).join('')}
	    `;
	}
    


    var showBaskets = function(){
		
		$.ajax({
			url:'/php/showBasketsForAdmin.php',
			type:'post',
			data:{
				start : start
			},
			beforeSend : function(){

			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);
				
				if(d.length > 0 ) {
				    
					start += 10;

					var append_tbody = `
					${d.map(function(row){
						return `
						${eachBasketTitle(row.basket)}
						<tr ${checkProcessAndBackground(row.basket[0].process)}>
							<td colspan="8">
								<div>
									<button class="printFactor">دریافت فاکتور</button>
								</div>
								<div class="smallFontSize print">
									<div class="basketHeader">
									${printBasketHeader(row.basket)}
									</div>
									<div>
										${printUserInformation(row.userInfo)}
									</div>
									<div class="eachProductInBasketForAdmin">
									    ${printPostPrice(row.basket)}
									</div>
									<div class="topMargin">
										${listItemsInBasketForAdmin(row.inside_basket)}
									</div>
								</div>
							</td>
						</tr>
						`
					}).join('')}
					`;

					startLoading = false;
					
					baskets_tbody.append(append_tbody);
					
				} else {
					startLoading = true;
				}
			},
			error : function() {
				
			}
		});
	};


	showBaskets();


	$(document).on('click','button.printFactor',function(){
		console.log('print factor');

		var parent = $(this).parent().parent();;
		console.log(parent);

		parent.find('div.print').printThis({
            debug: false,               // show the iframe for debugging
            importCSS: false,            // import parent page css
            importStyle: false,         // import style tags
            printContainer: true,       // print outer container/$.selector
            loadCSS: ["/css/admin.css","/css/fonts.css"],                // path to additional css file - use an array [] for multiple
            pageTitle: "Neka Beauty",              // add title to print page
            removeInline: false,        // remove inline styles from print elements
            removeInlineSelector: "",  // custom selectors to filter inline styles. removeInline must be true
            printDelay: 2000,            // variable print delay
            header: null,               // prefix to html
            footer: null,               // postfix to html
            base: false,                // preserve the BASE tag or accept a string for the URL
            formValues: true,           // preserve input/form values
            canvas: false,              // copy canvas content
            doctypeString: '',       // enter a different doctype for older markup
            removeScripts: false,       // remove script tags from print content
            copyTagClasses: false,      // copy classes from the html & body tag
            beforePrintEvent: null,     // function for printEvent in iframe
            beforePrint: null,          // function called before iframe is filled
            afterPrint: null            // function called before iframe is removed
        });
	});



	var inputProductSearch = $("input#productSearch");
	var sendSearchRequest = false;
	var isThereAnotherSearch = false;
	var prev_value = '';
	var loading = $('#loading');
	//var products_tbody = $('#products_tbody');

	var searchBasketsFunction = function(searchTerm){

			$.ajax({
			url :'/php/searchBasketsForAdmin.php',
			type:'post',
			data:{
			searchTerm : searchTerm,
			start : start
			},
			beforeSend: function() {
				loading.css('display','');
			},
			success : function(data) {
				var d = data;
				d = JSON.parse(d);
				console.log(d);

				sendSearchRequest = false;
				
				if ( d.length > 0 ){
					start += 10;
					startLoading = false;

					var append_tbody = `
					${d.map(function(row){
						return `
						${eachBasketTitle(row.basket)}
						<tr ${checkProcessAndBackground(row.basket[0].process)}>
							<td colspan="8">
								<div>
									<button class="printFactor">دریافت فاکتور</button>
								</div>
								<div class="smallFontSize print">
									<div class="basketHeader">
									${printBasketHeader(row.basket)}
									</div>
									<div>
										${printUserInformation(row.userInfo)}
									</div>
									<div class="topMargin">
										${listItemsInBasketForAdmin(row.inside_basket)}
									</div>
								</div>
							</td>
						</tr>
						`
					}).join('')}
					`;
	
					loading.css('display','none');
					baskets_tbody.append(append_tbody);

					
					//sendSearchRequest = false; // don't uncomment or you will f*
	
					if(isThereAnotherSearch == true){
						isThereAnotherSearch = false;
						sendSearchRequest = true;
						var searchTerm = inputProductSearch.val();
						searchBasketsFunction(searchTerm);
					}

				} else {
					startLoading = true;
					start = 0;
					loading.css('display','none');
				}
			},
			error : function() {
				
			}
		});
	}



	
	var delaySearch = function(){
		start = 0;
		searchTerm = inputProductSearch.val();
		searchTerm = $.trim(searchTerm);
		weAreInSearch = true;
		baskets_tbody.html('');
		

		if(searchTerm == prev_value){
			return false;
		}
		
		if( searchTerm === '' ){
			weAreInSearch = false;
			startLoading = false; 
			showBaskets();
			return false;
		}

		//console.log(sendSearchRequest);
		
		if( sendSearchRequest == false ){
			sendSearchRequest = true;
			searchBasketsFunction(searchTerm);
		} else {
			isThereAnotherSearch = true;	
		}

		prev_value = searchTerm;
		
	}
	
	var searchTimeOut;

	inputProductSearch.keyup(function(){
		clearTimeout(searchTimeOut);
        searchTimeOut = setTimeout(function(){ 
            delaySearch();
        }, 1000); 
				
	});




});