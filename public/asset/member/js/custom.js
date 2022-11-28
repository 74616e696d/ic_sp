$(document).ready(function() {
	
$('.colps').click(function(e){
	e.preventDefault();
	$(this).parent('div').parent('div').children('.bx-body').slideToggle('2000');
	$("i",this).toggleClass("fa-angle-up fa-angle-down");
});


$('#rpt-menu').on('shown.bs.collapse', function () {
   $(".fa-clps").removeClass("fa-angle-down").addClass("fa-angle-up");
});

$('#rpt-menu').on('hidden.bs.collapse', function () {
   $(".fa-clps").removeClass("fa-angle-up").addClass("fa-angle-down");
});

});

var studypress={};

studypress.disable_copy_paste=function(){
	$(document).bind('ctrl+s', function(){$('#save').click(); return false;});
	 $(document).bind("contextmenu",function(e){
	        return false;
	 });
}