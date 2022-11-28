@extends('front_layout.layout')

@section('content')
<div class="row">
	<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
	<h3>Take A Free Practice Quiz </h3>
		<ul class='list-group'>
	 		 {{ $qlist }}
	  	</ul>
<h4 style=background:#0177BF;padding:10px;color:#fff;>আরো বিষয়ভিত্তিক পরীক্ষা দিতে এবং অসংখ্য পরীক্ষার্থীর মাঝে নিজের অবস্থান যাচাই করতে <a href="{{ $base_url }}public/user_reg">আজই রেজিস্ট্রেশন করুন</a></h4>
	  	

	  	<div id="status-bottom">
			<p><span class='icn icn-ok'></span><label id='lblCorrect'>0</label></p>
			<p><span class='icn icn-cross'></span><label id='lblWrong'>0</label></p>
		</div>
		
		<div class="fb-comments" data-href="{{$base_url}}member/sample_practice" data-width='100%' data-numposts="5" data-colorscheme="light"></div>	
	 </div>
</div>

@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
<style>
.list-group
{
	background:#fff;
	padding:7px;
	margin-top:20px;
}
.list-ques
{
	background:#f2f2f2;
	font-size:14px;
	padding-left:4px;
}
.list-hint
{
	font-size:13px;
}
 .form-horizontal .control-label
 {
  padding-top:0;
 }
 .list-group-item
 {
 	border:none;
 }
 #status-bottom
 {
 	height:105px;
 	padding-left:8px;
 }
</style>
@stop

@section('script')
<script type="text/javascript">
	//disable mouse context menu
	$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
	 $(document).bind("contextmenu",function(e){
	        return false;
	 }); 
	//end disable mouse context menu

	$(function(){
	//Calc Object with display,clear,doCal methods
	    var Calc={
	        display:function(v){
	            $("#display").val(v);
	        },
	        clear:function(){
	            $("#display").val(" ");
	        },
	        doCal:function(val){
	            var result="";
	            var dtemp=$("#display").val();
	            if(dtemp=="0"){
	                this.clear();
	                result=val;
	            }else if(val=="c"){
	                this.clear();
	            }else if(val=="="){
	                result=eval(dtemp);
	            }else{
	                result=dtemp+val;
	            }
	            this.display(result);
	        }
	    }
	    //Keyboard key press event.
	    $("body").keypress(function(e){
	        Calc.doCal(String.fromCharCode(e.which));
	    });
	    //calc UI click events
	    $('.calc button').click(function(e){
	        e.preventDefault();
	        Calc.doCal(this.value);
	    });
	});


	</script>
	<script type="text/javascript">
		$(document).ready(function() 
		{
			$('.calc').hide();

			$('.exp').click(function(e){
				e.preventDefault();
				$('.calc').toggle('2000');
				//$(this).parent('div').parent('div').children('.bx-body').slideToggle('2000');
				$("i",this).toggleClass("fa-expand fa-compress");
			});

			$('.list-hint').hide();
		var ttl_ques=$('#hdn_ttl_ques').val();
			$('input:radio').click(function(){
				var rd_name=$(this).attr('name'),
					rd_class=$(this).attr('class'),
					given_ans=$(this).parent("li").children("span").text(),
					splited_rd_class=rd_class.split("_"),
					qsl=splited_rd_class[1],
					correct_ans_id="hdn_correct_ans_"+qsl;
					correct_ans=$("#"+correct_ans_id).val();
					hint_id=$("#list_hint_"+qsl);
					qid=$("#hdn_qid_"+qsl).val();

			if(given_ans==correct_ans)
			{
				$(this).parent('li').addClass('correct');
				hint_id.show();
			}
			else
			{
				$(this).parent('li').addClass('wrong');
				$("input[name="+rd_name+"]").each(function()
				{
					if($(this).parent('li').children('span').text()==correct_ans)
					{
						$(this).parent('li').addClass('correct');
					}
				});

		

				hint_id.show();

			}
			
			var sts=get_correct(),
				sts_arr=sts.split('_');
				$('#lblCorrect').text(sts_arr[0]);
				$('#lblWrong').text(sts_arr[1]);
			
			});


		  //toggle the componenet with class msg_body
		  $("#fold").click(function(e)
		  {
		  		e.preventDefault();
		  		var cls=$('#summery a i').attr('class');
		    	//$('#summery>div').slideToggle(1000);
		    	if(cls=='fa fa-compress fa-lg')
		    	{
		    		$('#summery>div').fadeOut(500);
		    		$('#summery a i').removeAttr('class');
		    		$('#summery a i').attr('class', 'fa fa-expand fa-lg');
		    	}
		    	else
		    	{
		    		$('#summery>div').fadeIn(500);
		    		$('#summery a i').removeAttr('class');
		    		$('#summery a i').attr('class', 'fa fa-compress fa-lg');
		    	}
		    	//$('#summery a i').toggleClass('fa fa-expand fa-lg');
		  });
		});

		function get_correct()
		{
			var allList=$('.list-group-item'),
				i=0,
				w=0;
			$.each(allList, function() {
				var optRange=$(this).nextUntil('.list-group-item');
				var optGiven=optRange.find('input[type=radio]:checked').parent("li").children("span").text();
				var optCorrect=optRange.find('input[type=hidden]').val();
				
				if(optGiven.length!=0)
				{
					if(optGiven==optCorrect)
					{
						i++;
					}
					else
					{
						w++;
					}
				}

			});
			return i+"_"+w;
		}

	  function showSuccess(msg)
	  {
	        toastr.success(msg);
	  } //function to display Success message
	  
	</script>


	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1390651954534358";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
@stop
