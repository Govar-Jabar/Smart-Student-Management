

 function loa(data){
  if(data==''){data=500}
document.getElementById("sp").style.display = "block";
setTimeout(function(){
   $(".sp").fadeOut("slow");
}, 500);

}

setTimeout(function(){
   $(".sp").fadeOut("slow");

}, 600);

$('#main-menu').metisMenu();

/*====================================
LOAD APPROPRIATE MENU BAR
======================================*/
$(window).bind("load resize", function () {
if ($(this).width() < 768) {
    $('div.sidebar-collapse').addClass('collapse')
} else {
    $('div.sidebar-collapse').removeClass('collapse')
}
});






// function confirmation(){
// return confirm('دڵنیای لە ئەنجامدانی ئەم کردارە؟');
// }      
    function newPopup(url) {
        window.open(url,'_blank',"width=1000,height=650,toolbar=0,location=0,scrollbars=yes");
    }                    
                    
        function notic1(d1){
          if(d1==2){
            $('#class').hide();
          }          
          if(d1==3){
            $('#class').show();
          }
        }


     // $('#demo').collapse('hide');
    $( document ).ready(function() {
    $("#r").change(function(){

     if ($(this).val()=="1" ){
          $('#demo').collapse('show');
      }
     else{
          $('#demo').collapse('hide');
     }
})
});

 function del(data){
setTimeout(function(){
   $("."+data).fadeOut("slow");
}, 500);

}

function mul(va){
    document.getElementById("etm").selectedIndex = va;
    $('.etm').selectpicker('refresh')

}