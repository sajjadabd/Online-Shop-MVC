var next  = $("#next");
var enter = $("#enter");
var back  = $("#back");
var phone = $("#phone");
var sms   = $("#sms");

next.on('click',function(){
    var inputPhone = phone.val();
    console.log(inputPhone);
    $.ajax({
        url:'/php/adminLogin/checkAdminLogin.php',
        type:'post',
        data:{
            phone : inputPhone
        },
        beforeSend: function(){
        },
        success : function(data){
            var d = data;
            d = JSON.parse(d);
            console.log(d);

            if(d.success !== undefined ){
                
                if( d.success === true ){
                    next.css('display','none');
                    phone.css('display','none');
                    sms.css('display','');
                    enter.css('display','');
                    back.css('display','');
                }
            }
            
        },
        error : function(){
        }
    });
});

enter.on('click',function(){
    var inputSms   = sms.val();
    var inputPhone = phone.val();
    //console.log(inputSms);
    $.ajax({
        url:'/php/adminLogin/checkAdminLogin.php',
        type:'post',
        data:{
            sms     : inputSms,
            phone   : inputPhone
        },
        beforeSend: function(){
        },
        success : function(data){
            var d = data;
            d = JSON.parse(d);
            //console.log(d);
            if(d !== undefined){
                if(d.phone !== undefined && d.sms !== undefined){
                    localStorage.setItem("admin_phone", inputPhone);
                    localStorage.setItem("admin_sms", inputSms);
                    //console.log('redirect')
                    window.location.href = "../addItem";
                    
                } else {
                    localStorage.removeItem("admin_phone");
                    localStorage.removeItem("admin_sms");
                }
            } else {
                localStorage.removeItem("admin_phone");
                localStorage.removeItem("admin_sms");
            }
            
        },
        error : function(){
        }
    });
});

back.on('click',function(){
    
    next.css('display','');
    phone.css('display','');
    sms.css('display','none');
    enter.css('display','none');
    back.css('display','none');
});