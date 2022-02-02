// Get the modal
var modal = document.getElementById("myModal");
var modalForDelete = document.getElementById("myModal-delete-item");

// Get the button that opens the modal
var btn = document.querySelectorAll(".checkLogin");

//console.log(btn);

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
/*
for(i=0;i<btn.length;i++){
  btn[i].addEventListener('click',function(){
	  if( localStorage.phone === undefined || localStorage.sms === undefined ){
		  modal.style.display = "block";
	  } else {
		  
	  }
    
  });
}
*/


// When the user clicks on <span> (x), close the modal
span.addEventListener('click',function(){
  modal.style.display = "none";
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


window.onclick = function(event) {
  if (event.target == modalForDelete) {
    modalForDelete.style.display = "none";
  }
}