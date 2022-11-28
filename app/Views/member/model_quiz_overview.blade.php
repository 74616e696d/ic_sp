@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">{{model_test_model::get_text($test_id)}}</h4>
			</div>
			<div class="bx-body">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="box box-ok">
						<i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Right Answer
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="box box-wrong">
						<i class="fa fa-times"></i>&nbsp;&nbsp;Wrong Answer
					</div>
				</div>
				<div class="clearfix"></div>
				{{$list}}

				<?php
					$expert_review=$quiz_summery?$quiz_summery->expert_review:'';
				?>
				@if(!empty($expert_review))
				<hr>
				<h4>Expert Review Summary: </h4>
				@endif
				<p id='quiz_summery_para'>{{$expert_review}}</p>
				@if($is_admin)
				<hr>
				<textarea id="txt_review_summery" cols="30" rows="10" class="form-control" placeholder="Write an expert review summery here !!"></textarea><br>
				<button type='button' data-summeryid="{{$quiz_summery?$quiz_summery->id:''}}" id='expert_review_summery' class='btn btn-primary btn-sm'>Save</button>
				@endif
				<hr>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
<style>
		.list-group {
		  padding-left: 0;
		  margin-bottom: 20px;
		}

		.list-group-item {
			color:#353535;
		  position: relative;
		  display: block;
		  padding: 10px 15px;
		  background-color: #ffffff;
		  border: 1px solid #f6f6f6;
		  font-size:15px;
		  /*font-weight:bold;*/
		  margin-bottom:0;
		}

		.list-group-item:first-child {

		}

		.list-group-item:last-child {
		  margin-bottom: 0;
		}

		.list-group-item > .badge {
		  float: right;
		}

		.list-group-item > .badge + .badge {
		  margin-right: 5px;
		}
	 .list-option
	 {
	 	color:#353535;
	 	background-color: #FFFFFF;
	    display: block;
	    margin-bottom: -1px;
	    padding: 10px 16px;
	    position: relative;
	    line-height:18px;
	    font-size:14px;
	}
	.list-hint
	{
		background-color: #FFFFFF;
		color:#444;
	    /*border: 1px solid #DDDDDD;*/
	    display: block;
	    font-size:12px;
	    margin-bottom: -1px;
	    padding: 10px 16px;
	    position: relative;
	}
	.correct
	{
		color:#34B27D;
		font-weight: bold;
		
	}
	.wrong
	{
		color:#ff0000;
		font-weight:bold;
		
	}
	#hd
	{
		height:50px;
	}
	#hd>div
	{
		height:50px;
		width:26%;
		padding-left:13px;
		padding-top:12px;
	/*	float:left;*/
	}
	.spn-green
	{
		display:block;
		height:20px;
		width:20px;
		background:#34B27D;
		float:left;
	}
	.spn-red
	{
		display:block;
		height:20px;
		width:20px;
		background:#ff0000;
		float:right;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.totop.js"></script>
<script>
studypress.disable_copy_paste();

$(document).ready(function() {
	/**
	 * add question specific expert review summery
	 */
	$('.btnReview').click(function(e){
		e.preventDefault();
		var that=$(this);
		var qid=that.data('qid');
		var ask_id=that.data('ask');
		var details=that.prev("textarea").val();
		$.ajax({
			url: '{{$base_url}}member/model_quiz_progress/add_expert_review',
			type: 'POST',
			data: {qid:qid,ask_id:ask_id,details:details}
		})
		.done(function(data) {
			alert('successfully added!');
		});
	});


	/**
	 * add expert review summery
	 */
	$('#expert_review_summery').click(function(){
		var that=$(this);
		var summery_id=that.data('summeryid');
		var review=$('#txt_review_summery').val();
		$.ajax({
			url: '{{$base_url}}member/model_quiz_progress/add_expert_review_summery',
			type: 'POST',
			data: {summery_id:summery_id,review:review}
		})
		.done(function(res) {
			if(res=='1')
			{
				$('#quiz_summery_para').html(review);
				$('#txt_review_summery').val('');
				alert('successfully saved !');
			}
			else
			{
				alert('Unable to save !!');
			}
		});
		
	});

});

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
@stop