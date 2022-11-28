<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Quiz Result | Iconpreparation</title>
	<link href="<?php echo $base_url(); ?>asset/member/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo $base_url(); ?>asset/member/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<style>
	.container
	{
		padding-top:8%;
	}
	.container>div
	{
		padding:10px;
		border:1px solid #ddd;
	}
	.table caption
	{
		font-size:18px;
	}
	.list-group-item span
	{
		float:right;
		text-align:left;
		width:60%;
	}
	.copy
	{
		float:right;
		padding-right:8px;
	}
	.copy>a
	{
		color:#444;
	}
	#result
	{
		background:#f6f6f6;
	}
	</style>
</head>
<body>
	<div class="row">
		<div class="container">
		<div id='result' class="col-sm-6 col-sm-offset-3">
		
		<div id='table'>
			<h3>Result Of {{$username}}</h3>
			<a href="#" style='float:left;' class="print"><i class="fa fa-print"></i></a>
			<a class='btn btn-default btn-xs' style='float:right' href="<?php echo $base_url(); ?>member/quiz_result_details/index/{{$quiz_id}}"><i class="fa fa-eye">&nbsp;&nbsp;View Details</i></a>
			<div class="clearfix"></div>
			<br>
			<ul class='list-group'>
				<li class="list-group-item"><strong>Quiz ID:</strong><span>{{$result['qid']}}</span></li>
				<li class="list-group-item"><strong>Chapter:</strong><span>{{$result['chapter']}}</span></li>
				<li class="list-group-item"><strong>Date:</strong><span>{{$result['dt']}}</span></li>
				<li class="list-group-item"><strong>Time Taken:</strong><span>{{$result['time']}}</span></li>
				<li class="list-group-item"><strong>Total Correct:</strong><span>{{$result['correct']}}</span></li>
				<li class="list-group-item"><strong>Total Wrong:</strong><span>{{$result['wrong']}}</span></li>
			</ul>
			</div>
			<a href="<?php echo $base_url(); ?>member/dashboard">Back To Dashboard</a>
			<span class='copy'>&copy;&nbsp;{{date('Y')}}&nbsp;<a href="<?php echo $base_url(); ?>">iconpreparation.com</a></span>
		</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url(); ?>asset/js/jQuery.print.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.print').click(function(e){
				e.preventDefault();
				$('#table').print();

			});
		});
	</script>
</body>
</html>