@extends('master.layout')

@section('content')

<div class="row">
<div class="col-sm-12">
	<div class="bx">
		<div class="bx bx-header">
			<h4 class="bx-title">Answer Review</h4>
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
			<?php echo $list; ?>
			<div id="totopscroller"></div>
		</div>
	</div>
</div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/totopFA.css">
<style>
 .list-option
 {
 	color:#353535;
 	background-color: #FFFFFF;
    /*border: 1px solid #DDDDDD;*/
    display: block;
    margin-bottom: -1px;
    padding: 10px 16px;
    position: relative;
    line-height:18px;
    font-size:15px;
}
.list-hint
{
	background-color: #FFFFFF;
	color:#777777;
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