$(document).ready(function(){
    var backToTop = $('#backToTop');
    

    backToTop.on('click',function(e){
        //console.log('click');
        
        $('html, body').animate({
            scrollTop : 0
        }, 1000);
        
        e.preventDefault();
        
    });
    
    /*
    $(window).on('scroll',function(){
        //console.log('scroll');
        
        var self = $(this);
        var height = self.height();
        var top = self.scrollTop();

        var offset = 400;
        
        //console.log('height : ' + height);
        //console.log('top    : ' + top);
        var attr = backToTop.css('display');
        
        
        if( top > height - offset ){
            if( attr == 'none' )
                backToTop.fadeIn("slow");
        } else {
            if ( attr == 'flex' )
                backToTop.fadeOut("slow");
        }
        
    });
    */
    
   
});