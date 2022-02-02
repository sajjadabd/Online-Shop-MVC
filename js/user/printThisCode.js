$(document).ready(function(){


    $(document).on('click','button.printBasket',function(){
		//console.log('click button');
		var parent = $(this).parent().parent();
        //console.log(parent);
        

        parent.find('div.print').printThis({
            debug: false,               // show the iframe for debugging
            importCSS: false,            // import parent page css
            importStyle: false,          // import style tags
            printContainer: true,       // print outer container/$.selector
            loadCSS: ["/css/basket.css","/css/fonts.css"],                // path to additional css file - use an array [] for multiple
            pageTitle: "Neka Beauty",              // add title to print page
            removeInline: false,        // remove inline styles from print elements
            removeInlineSelector: "",  // custom selectors to filter inline styles. removeInline must be true
            printDelay: 1500,            // variable print delay
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
    

});