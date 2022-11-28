@extends('master.layout')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Total {{$total_ques}} questions</h4>
			</div>
			<div class="bx bx-body">
				@include('master.mark')
				<div class="clearfix"></div>
				<input type="hidden" id="hdn_ttl_ques" value="<?php echo $total_ques; ?>"/>
				<div>
					<?php echo $qlist; ?>
				</div>
				<div id="status">
					<p><span class='icn icn-ok'></span><label id='lblCorrect'>0</label></p>
					<p><span class='icn icn-cross'></span><label id='lblWrong'>0</label></p>
				</div>
				<div id="totopscroller"></div>
			</div>
		</div>
	</div>
</div>

@stop
@section('style')
	 <link type='text/css' rel='stylesheet' href='<?php echo base_url(); ?>asset/css/toastr.css'/>
	<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
@stop
@section('script')
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.totop.js"></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/toastr.min.js'></script>
	<script>
		//disable context menu
		$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
		 $(document).bind("contextmenu",function(e){
		        return false;
		 }); 
		 //end disable context menu


		$(function(){
			$('#totopscroller').totopscroller({
				link:'<?php echo base_url(); ?>member/progress_overview',
				toTopHtml: '<i class="fa fa-border fa-2x fa-chevron-up"></i>',
				toBottomHtml: '<i class="fa fa-border fa-2x fa-chevron-down"></i>',
				toPrevHtml: '<i class="fa fa-border fa-2x fa-chevron-left"></i>',
				// linkHtml: '<a><i class="fa fa-border fa-2x fa-link"></i></a>',
				});
			})
	</script>
	<script type="text/javascript">
		$(document).ready(function() 
		{
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
					hint_id=$("#list_hint_"+qsl),
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

				//add wrong attempt to mistake to mistake list
				$.ajax({
					url: '<?php echo base_url(); ?>member/reading/add_to_mistake',
					type: 'POST',
					data: {qid:qid},
				})
				.done(function() {
					console.log("success");
				});
				//end add wrong attempt to mistake to mistake list

			}
			
			var sts=get_correct(),
				sts_arr=sts.split('_');
				$('#lblCorrect').text(sts_arr[0]);
				$('#lblWrong').text(sts_arr[1]);
			
			});


			$('.icn-mark').click(function(){
				var present=$(this),
					qid=qid=present.parent('li').children('input[type=hidden]').val();
					// alert(qid);
				$.ajax({
					url: '<?php echo base_url(); ?>/public/test/add_to_review',
					type:'POST',
					data: {qid:qid},
				})
				.done(function(msg) {
					showSuccess(msg);
				});
				
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
	       toastr.options = {
	          "closeButton": false,
	          "debug": false,
	          "positionClass": "toast-bottom-right",
	          "onclick": null,
	          "showDuration": "300",
	          "hideDuration": "1000",
	          "timeOut": "20000",
	          "extendedTimeOut": "1000",
	          "showEasing": "swing",
	          "hideEasing": "linear",
	          "showMethod": "fadeIn",
	          "hideMethod": "fadeOut"
	        }

	        toastr.success(msg);
	  } //function to display Success message
	</script>
@stop