var addItemButton = document.getElementById('addItemButton');
var form = document.getElementById('form');
var informations = form.querySelectorAll('[name]');
var picture = document.getElementById('file');

var formData = new FormData();

var send_item_data = false;

var upload = function (files) {

    for (i = 0; i < files.length; i++) {
        //console.log(files[i].name);
        formData.append('myFile[]', files[i]);
    }

};

picture.ondrop = function (e) {
    e.preventDefault();
    upload(e.dataTransfer.files);
    //console.log(e.dataTransfer.files);
    return false;
};

picture.ondragover = function () {
    picture.classList.add('green');
    return false;
};

picture.ondragleave = function () {
    picture.classList.remove('green');
    return false;
};

resetAllInput = function () {
    formData.delete('myFile');
    picture.classList.remove('green');
    for (i = 0; i < informations.length; i++) {
        if( informations[i].name === 'original') {
            informations[i].checked = false;
        } else if (informations[i].name !== undefined){
            informations[i].value = '';
        }
    }
};

addItemButton.addEventListener('click', function () {
    //console.log('clicked');
	if(send_item_data == false){
		send_item_data = true;
	} else {
		return false;
	}
	
    var data = {};

    for (i = 0; i < informations.length; i++) {
        if( informations[i].name === 'original') {
            data[informations[i].name] = informations[i].checked;
        } else if (informations[i].name !== undefined) {
            data[informations[i].name] = informations[i].value;
        }
    }

    data['picture'] = formData.getAll('myFile');
    //console.log(formData.getAll('myFile'));
    //data['picture'] = formData.get('myFile');

    //console.log(data);

    formData.append('title', data.title);
    formData.append('category', data.category);
    formData.append('brand', data.brand);
    formData.append('price', data.price);
    formData.append('original', data.original);

    


    $.ajax({
        url  : '/php/addItem.php',
        type :'post',
        data : formData,
        beforeSend: function(){

        },
        uploadProgress : function(event,position,total,percentComplete){
            console.log(percentComplete);
        },
        success : function(data){
            var d = data;
            d = JSON.parse(d);
            console.log(d);

            send_item_data = false;
        },
        error : function(){

        }
    });

    

    resetAllInput();
});

