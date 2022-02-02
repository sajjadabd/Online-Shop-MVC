$(document).ready(function(){
	$('i.fa-power-off').on('click',function(){
		localStorage.removeItem("admin_phone");
		localStorage.removeItem("admin_sms");
		
		window.location.href = "../../admin";
	});
});