@extends('master.layout')

@section('content')
<div class="row">
	

</div>

<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Chapter Quiz Mistake List</h4>
			</div>
			<div class="bx bx-body">
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
			color:#BBBBBB;
		    /*border: 1px solid #DDDDDD;*/
		    display: block;
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