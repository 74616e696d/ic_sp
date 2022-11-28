<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Unauthorised Access</title>
	<link href="{{$base_url}}asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="{{$base_url}}asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	<link href="{{$base_url}}asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	 <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="{{$base_url}}asset/css/font-awesome-ie7.min.css">
    <![endif]-->
	<style>
	body
	{
		font-family: Tahoma,Arial,Helvetica,sans-serif;
	}
	.container
	{
		padding-top:10%;
	}
	h2{
		color:#FF7F2A;
	}
	h2,h4
	{
		text-align:center;
	}
	p
	{
		text-align: center;
	}
	p a
	{
		color:#bebebe;
	}
	</style>
</head>
<body>
	<div class="row">
		<div class="container">
			<h2>YOU ARE NOT PERMITTED TO ACCESS THIS FEATURE</h2>
			<h4>Please upgrade your membership. <a href="{{$base_url}}public/upgrade">click here</a> to upgrade</h4>
			<p><a id='lnkBack' href=""><i class="fa fa-backward"></i>&nbsp;GO BACK</a></p>
		</div>
	</div>
	<script type="text/javascript" src="{{$base_url}}asset/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var ref=document.referrer,
			lnk='{{$base_url}}';
			if(ref.legth>0)
			{
				lnk=ref;
			}
			$('#lnkBack').attr('href',lnk);
		});
	</script>
</body>
</html>