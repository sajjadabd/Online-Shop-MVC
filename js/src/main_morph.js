/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
$(document).ready(function(){
	
	var bodyEl = document.body;
	//var	content = document.querySelector( '.content-wrap' );
	var	menubtn = $('.menu-button');
	var	menubtnicon = $('.fa-fw');
	var	isOpen = false;

	//console.log(menubtn[0]);
	//console.log(menubtnicon[0]);


	//menubtn.on( 'click', toggleMenu );
	//menubtnicon.on( 'click', toggleMenu );

	// close the menu element if the target it´s not the menu element or one of its descendants..
	bodyEl.addEventListener( 'click', function(ev) {
		var target = ev.target;
		var classes = target.classList.value;
		

		//console.log(`classes : ${classes}`);
		if( classes.search('fa-fw') >= 0 || classes.search('menu-button') >= 0 ) {
			//console.log('hit the point');
			toggleMenu();
		} else {
			if(isOpen === true){
				toggleMenu();
				//console.log('inside else toggle happens');
			}	
			
		}
	});
	

	function toggleMenu() {
		//console.log(`isOpen : ${isOpen}`)
		if( isOpen ) {
			classie.remove( bodyEl, 'show-menu' );
		} else {
			classie.add( bodyEl, 'show-menu' );
		}
		isOpen = !isOpen;
	}
	

});