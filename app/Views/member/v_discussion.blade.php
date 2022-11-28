@extends('master.layout');

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<!-- <div class="bx bx-header">
				<h4 class="bx-title"></h4>
			</div> -->
			<div class="bx bx body">
				<div id="fb-root"></div>
				<div id='<?php echo $qid; ?>'>
				<?php echo $ques; ?>
				</div>
				<hr>

				<div class="fb-comments" data-href="{{$base_url}}member/discussion/index{{$id}} ?>" data-numposts="5" data-colorscheme="light"></div>	
			</div>
		</div>
	</div>
</div>

@stop

@section('style')
	<style>
			.list-group 
			{
			  padding-left: 0;
			  margin-bottom: 20px;
			}

			.list-group-item {
				color:#353535;
			  position: relative;
			  display: block;
			  padding: 10px 15px;
			  /*margin-bottom: -1px;*/
			  background-color: #ffffff;
			  border: 1px solid #dddddd;
			  font-size:15px;
			  font-weight:bold;
			}

			.list-group-item:first-child {
			  border-top-right-radius: 4px;
			  border-top-left-radius: 4px;
			}

		.list-group-item:last-child 
		{
			margin-bottom: 0;
			border-bottom-right-radius: 4px;
			border-bottom-left-radius: 4px;
		}

		.list-group-item > .badge 
		{
			 float: right;
		}

		.list-group-item > .badge + .badge 
		{
			 margin-right: 5px;
		}
		 .list-option
		 {
		 	color:#353535;
		 	font-size:15px;
		 	background-color: #FFFFFF;
		    /*border: 1px solid #DDDDDD;*/
		    display: block;
		    margin-bottom: -1px;
		    padding: 10px 16px;
		    position: relative;
		    line-height:18px;
		}
		.list-hint
		{
			font:14px/30px !important;
			background-color: #FFFFFF;
			color:#BBBBBB;
		    /*border: 1px solid #DDDDDD;*/
		    display: block;
		    margin-bottom: -1px;
		    padding: 10px 16px;
		    position: relative;
		}

		.list-summery
		{
			font-size:15px !important;
			/*background-color: #f6f6f6;*/
			color:#444;
		    border: 1px solid #DDDDDD;
		    display: block;
		    height:30px;
		    line-height:30px;
		    margin-bottom: -1px;
		    padding-left:5px;
		    padding-right: 5px;

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
		.correct
		{
			color:#34B27D;
		}
		.wrong
		{
			color:#ff0000;
		}
		
		hr
		{
			color:#f6f6f6;
			border:1px solid #f6f6f6;
			padding-bottom:10px;
		}
		textarea
		{
			margin-left:10px;
			margin-bottom:10px;
			width:90%;
			background: none repeat scroll 0 0 #FCFCFC;
		    border: 1px solid #CCCCCC;
		    border-radius: 2px;
		    box-shadow: 0 1px 3px #DDDDDD inset;
		    color: #666666;
		    padding: 6px 5px;
		}

		textarea:focus
		{ 
			background: #fff; 
			-moz-box-shadow: inset 1px 1px 2px #eee; 
			-webkit-box-shadow: inset 1px 1px 2px #eee;
			 box-shadow: inset 1px 1px 2px #eee; 
		}
		.fb-comments
		{
			margin-left:15px;
			width:100%;
		}

	</style>
@stop

@section('script')
<script>
	studypress.disable_copy_paste();
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1390651954534358";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
@stop





