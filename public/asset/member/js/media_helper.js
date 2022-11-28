
function checkMedia()
{
	if (window.matchMedia('(max-width: 320px)').matches) 
	{
		$('#sidebar').hide();
		$('.clockDiv').hide();
		$('#left-portion').addClass('top-left');
		$('#right-portion').addClass('top-right');
		$('#qlist').addClass('qlist-mobile');

		$('.calc').addClass('calc-mobile');

		$('.calc').hide();
		$('.exp').click(function(){
			$('#sidebar').slideToggle('2000');
			$("i",this).toggleClass("fa-angle-up fa-angle-down");
		});

		$('#exp-calc').click(function(){
			$('.calc').slideToggle('2000');
			$("i",this).toggleClass("fa-collapse fa-expand");
		});

		
	} 
	else if(window.matchMedia('(max-width: 480px)').matches)
	{
	    $('#sidebar').hide();
	    $('.clockDiv').hide();
	    $('#left-portion').addClass('top-left');
	    $('#right-portion').addClass('top-right');
	    $('#qlist').addClass('qlist-mobile');
	    $('.calc').addClass('calc-mobile');
	    $('.calc').hide();
	    $('.exp').click(function(){
			$('#sidebar').slideToggle('2000');
			$("i",this).toggleClass("fa-angle-up fa-angle-down");
		});


		$('#exp-calc').click(function(){
			$('.calc').slideToggle('2000');
			//$("i",this).toggleClass("fa-compress fa-expand");
		});
	}
	else if(window.matchMedia('(max-width: 768px)').matches)
	{
		$('#sidebar').hide();
		$('#left-portion').addClass('top-left');
		$('#right-portion').addClass('top-right');
		$('#qlist').addClass('qlist-mobile');
		$('.calc').addClass('calc-mobile');
		$('.calc').hide();

		$('.clockDiv').hide();

		$('#exp-calc').click(function(){
			$('.calc').slideToggle('2000');
			//$("i",this).toggleClass("fa-compress fa-expand");
		});
	}
	else
	{
		$('#left-portion').removeClass('top-left');
		$('#right-portion').removeClass('top-right');
		$('#qlist').removeClass('qlist-mobile');
		$('.calc').removeClass('calc-mobile');
	}

}
checkMedia();
// $(window).resize(function(){
// 	checkMedia();
// });