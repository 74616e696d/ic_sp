@extends('master.layout')

@section('content')

<!-- <div id="facebook_invite"></div>
<button id='invite'>Invite Facebook Friends</button>

<div class="row">
	
</div> -->

<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Practice-{{$chapter_text}}</h4>
			</div>
			<div class="bx bx-body">
				@include('master.mark')
				<div class="clearfix"></div>
				<div>
					<p>Total <strong><?php echo $ttl_ques; ?></strong> question found</p>
					<?php echo $qlist; ?>

					{{--{{$fmistake}}--}}
				</div>
				<?php if(!empty($tips)){ ?>
				<div id="summery">
				<a href="" id='fold'><i class='fa fa-compress fa-lg'></i>&nbsp;Hot Tips</a>
					<div>
						<?php echo $tips; ?>
					</div>
				</div>
				<?php } ?>

				<?php $chapter_arr=array('83','118','125','126','127','229','84','116','117','210','211','212','213','214','215','234','307','128','129','130','131','132','133','134','135','136','137','138','139','140','233');
					$show_calc=in_array($chapter_id,$chapter_arr)?true:false;
				 ?>
				<div id="status-bottom">
					<p><span class='icn icn-ok'></span><label id='lblCorrect'>0</label></p>
					<p><span class='icn icn-cross'></span><label id='lblWrong'>0</label></p>
				</div>
				@if($show_calc)
				<div class="cal-container">
					<a class='exp' href=""><i class="fa fa-expand"></i>&nbsp;Calculator</a>
					@include('member.exam.calc');
				</div>
				@endif
				<div id="totopscroller"></div>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<!-- <link rel="stylesheet" href="{{ $base_url }}asset/vendor/pagination/simplePagination.css"> -->
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
<link rel="stylesheet" href="{{$base_url}}asset/member/css/calc.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
<style>
	#btnClear{display: none;}
	.cal-container
	{
		/*background:#900;*/
		border-top-right-radius: 5px;
		top:20%;
		/*box-shadow: 1px 1px 1px #ccc;*/
		color: #f6f6f6;
		/*height: 270px;*/
		right: 0;
		opacity: 0.9;
		/*padding-top: 10px;*/
		position: fixed;
		/*width: 250px;*/
	}
	.exp
	{
		display:block;
		padding-top:2px;
		padding-left:3px;
		color:#444;
	}
	/*.cal-container
	{
		background:#900;
		width:260px;
		height:250px;
	}*/
</style>
@stop

@section('script')
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.totop.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/toastr.min.js'></script>
<script type="text/javascript" src="{{ $base_url }}asset/member/js/jquery.twbsPagination.min.js"></script>
<script>

//disable mouse context menu
$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
$(document).bind('keydown', 'ctrl+u', function(){$('#save').click(); return false;});
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


	$(function(){
		$('#totopscroller').totopscroller({
			link:'<?php echo base_url(); ?>member/progress_overview',
			toTopHtml: '<i class="fa fa-border fa-2x fa-chevron-up"></i>'
			});
		});



$('#invite').click(function(){
	FB.ui({
	 method: 'apprequests',
	 message: 'Invite your Facebook Friends'
	},function(response) {
	 if (response) {
	  alert('Successfully Invited');
	 } else {
	  alert('Failed To Invite');
	 }
	});
});
// function FacebookInviteFriends()
// {
// FB.ui({
// method: 'apprequests',
// message: 'Invite your friends'
// });
// }
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

			$.ajax({
				url: '<?php echo base_url(); ?>member/reading/add_to_mistake',
				type: 'POST',
				data: {qid:qid},
			})
			.done(function() {
				console.log("success");
			});
			

			hint_id.show();

		}
		
		var sts=get_correct(),
			sts_arr=sts.split('_');
			$('#lblCorrect').text(sts_arr[0]);
			$('#lblWrong').text(sts_arr[1]);
		
		});


		$('.icn-mark').click(function(){
			var present=$(this),
				qid=present.parent('li').children('input[type=hidden]').val();
				//alert(qid);
			$.ajax({
				url: '<?php echo base_url(); ?>/public/test/add_to_review',
				type:'POST',
				data: {qid:qid},
			})
			.done(function(msg) {
				toastr.success(msg);
				//showSuccess(msg);
			});
			
		});

	  //toggle the componenet with class msg_body
	  $('#summery>div').hide();
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
@stop




