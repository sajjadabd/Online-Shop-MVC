$(document).ready(function(){

    var content = $('#complainsContent');

    $.ajax({
        url  : '/php/showComplainsForAdmin.php',
        type : 'post',
        data : {},
        beforeSend : function(){

        },
        success : function(data){
            var d = data;
            d = JSON.parse(d);
            console.log(d);

            if(d.length>0){
                var append_tbody = `
                ${d.map(function(row){
                    return `
                    <div class="eachComplain">
                        <div class="row">
                            <div class="complain_title">
                                <div> &nbsp; : موضوع  </div>
                                <div>${row.complain_title}</div>
                            </div>
                            <div class="phone">
                                <div> &nbsp; : شماره تلفن  </div>
                                <div>${row.phone}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="complain_text">
                                <div> &nbsp; : متن </div>
                                <div>${row.complain_text}</div>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('')}
                `;
            } else {

            }

            content.html(append_tbody);
        },
        error : function(){

        }
    });
});