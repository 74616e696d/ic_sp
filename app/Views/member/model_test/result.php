@extends('master.layout')
@section('content')

<div class="row">

	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Selected Chapters</h4>
			</div>
			<div class="bx bx-body">
				<ol class="breadcrumb">
				  <li><a href="{{$base_url}}member/practice_subject_list">Read &amp; Practice</a></li>
				  <!-- <li><a href="{{$base_url}}member/practice_subject_list">{{ref_text_model::get_text($exam_id)}}</a></li>
				  <li class="active">{{ref_text_model::get_text($subj_id)}}</li> -->
				</ol>
				<div id='qlist' class="tbl-responsive">
					<!-- <div > -->
					<!-- {{$default}} -->
					<!-- </div> -->
				</div>
				<br><br>

				<div id='loading'>
					<img src="<?php echo base_url(); ?>images/loaders/loader7.gif" alt="waiting">
				</div>
				<div id="totopscroller"></div>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/table.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
<style>
#content{padding-left:20px;padding-top:20px;}
.stdform select
{
	margin-left:10px;
	width:200px;
}

#loading
{
	display:none;
}
.progressbar {
    color: #3C8DBC;
    text-align: right;
    height: 25px;
    /*width:90% !important;*/
    border-radius:5px;
    box-shadow:2px 2px 2px #f6f6f6;
}
.tr_chapter td:nth-child(2)
{
	width:35%;
}

.tbl-responsive tr th:nth-child(2),.tbl-responsive tr td:nth-child(2)
{
	width:20%;	
}

.tbl-responsive tr th:nth-child(3),.tbl-responsive tr td:nth-child(3)
{
	width:35%;	
}
@media only screen and (max-width: 800px) 
{
	#btn-search
	{
		margin-top:5px;
	}
	.tbl-responsive tr th:nth-child(2),.tbl-responsive tr td:nth-child(2)
	{
		width:100%;	
	}

	.tbl-responsive tr th:nth-child(3),.tbl-responsive tr td:nth-child(3)
	{
		width:100%;	
	}

	.action:before	
	{
		padding-right:0 !important;
	}

}
</style>
<link rel="stylesheet" href="{{$base_url}}asset/css/loader.css">
@stop

@section('script')
<script type="text/javascript" src='{{$base_url}}asset/member/js/plugins/jqueryKnob/jquery.knob.js'></script>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.totop.js"></script>
<script>
$(function()
{
	$('#totopscroller').totopscroller({
		link:'<?php echo base_url(); ?>member/progress_overview',
		toTopHtml: '<i class="fa fa-border fa-2x fa-chevron-up"></i>',
		toBottomHtml: '<i class="fa fa-border fa-2x fa-chevron-down"></i>',
		toPrevHtml: '<i class="fa fa-border fa-2x fa-chevron-left"></i>',
		});
})
</script>
@stop




