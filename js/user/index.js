var bars = document.getElementById("bars");
var close = document.getElementById("close");
var sidenav = document.getElementById("sidenav");
var content = document.getElementById("content");
var header = document.getElementById("topHeader");
var modalForSideNav = document.getElementById("sideNavModal");


modalForSideNav.onclick = function(event) {
    if (!event.target.matches('.sidenav') && !event.target.matches('.category')) {
        //var TAG = event.target.tagName;
        //if (TAG !== 'A'){
        closeSideNav();
        //}
    }
};


openSideNav = function(){
    //console.log("bars clicked");
    sidenav.style.transition = ".5s";
    sidenav.style.right = '0';
    $("#sideNavModal").css('display','');
    bars.style.visibility = "hidden";
    //modalForSideNav.style.display = "block";
};

closeSideNav = function() {
    //console.log("close clicked");
	sidenav.style.position = "fixed";
    sidenav.style.transition = "0s";
    sidenav.style.right = '-180px';
    bars.style.visibility = "";
    $("#sideNavModal").css('display','none');
    //modalForSideNav.style.display = "";
};

bars.addEventListener('click',function(){
    openSideNav();
    setTimeout(function(){ 
        sidenav.style.position = "absolute";
    }, 500);
    
    $("#sideNavModal").css('display','block');
});

close.addEventListener('click',function(){
    closeSideNav();
    $("#sideNavModal").css('display','none');
});


