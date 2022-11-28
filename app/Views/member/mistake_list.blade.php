@extends('master.layout')

@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="bx bx-primary">
            <div class="bx bx-header">
            <h4 class="bx-title">Total <strong><?php echo $ttl_ques; ?></strong> question found</h4>
            </div>
            <div class="bx-body">
	           @include('master.mark')
	            <br>
            <br>
            <div class="table-responsive">
	            <?php echo $qlist; ?>
	           </div>
	           <?php if(!empty($tips)){ ?>
	            <div id="summery">
	                <a href="" id='fold'><i class='fa fa-compress fa-lg'></i></a>
	                <div>
	                    <?php echo $tips; ?>
	                </div>
	            </div>
	            <?php } ?>
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
<link type='text/css' rel='stylesheet' href='{{$base_url}}asset/css/toastr.css'/>
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
@stop

@section('script')
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.totop.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/toastr.min.js'></script>
<script>
//$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
 $(document).bind("contextmenu",function(e){
        return false;
 }); 

		$(function(){
			$('#totopscroller').totopscroller({
				link:'<?php echo base_url(); ?>member/progress_overview',
				toTopHtml: '<i class="fa fa-border fa-2x fa-chevron-up"></i>'
				});
			})
</script>
<script type="text/javascript">
function clear_ques(qid)
{
	$("input[value='"+qid+"']").parent('li').nextUntil('.list-group-item').remove();
	$("input[value='"+qid+"']").parent('li').remove();
}
function delete_ques(qid)
{
	var conf = confirm("Are you confirm delete??");
	if(conf == true)
	{
		$.ajax({
			url: '{{$base_url}}member/mistake_list/remove',
			type: 'POST',
			data: {qid:qid},
		})
		.done(function(data) {
			if(data='success')
			{
				toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "positionClass": "toast-bottom-right",
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "5000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"}
			  clear_ques(qid);
				toastr.success('successfully deleted!!');
			}
			else
			{
				toastr.error("unbale to delete!!");
			}
		});
		
		//window.location.href = "<?php echo base_url();?>member/mistake_list/remove/"+qid;		
	}
	else
	{
		return false;
	}
}
$(document).ready(function() 
{
	$('#btnClear').click(function(e) {
		e.preventDefault();
		var conf=confirm('Are you sure to clear all the mistake list ??');
		if(conf){
		var clearUrl='{{$base_url}}member/mistake_list/clearAll';
		window.location.href=clearUrl;
		}
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

	$('.icn-mark').click(function(){
		var present=$(this),
			qid=present.parent('li').children('#hdn_qid').val();
			
		// $.ajax({
		// 	url: '<?php echo base_url(); ?>/public/test/add_to_review',
		// 	type:'POST',
		// 	data: {qid:qid},
		// })
		// .done(function(msg) {
		// 	showSuccess(msg);
		// });
		
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
