<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>ICONPREPARATION|LOGIN</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/login.css" media="screen" />
<style>
#loggin-temp
{
	font-size:18px;
	padding-left:10px;
}

.alert 
{
	background-color: #fcf8e3;
	border: 1px solid #fbeed5;
	border-radius:none;
	margin-bottom:0;
	padding: 8px 35px 8px 14px;
	/*text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);*/
}
</style>
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
				<h2><img alt="logo" src="<?php echo base_url(); ?>asset/frontend/img/logo.png"></h2>
				
				{{render_message()}}

				@if(!$authenticated)

				<form action="<?php echo base_url(); ?>login/global_sign_in" method="post">
					<label for="login">Username:</label>
					<input id="login" name="login" class="text" placeholder="user name" required="required" />
					<label for="pass">Password:</label>
					<input id="pass" name="pass" type="password" class="text" placeholder="passsword" required="required"/>
					<div class="sep"></div>
					<button type="submit"><i style="color:#F97307;" class="fa fa-check"></i>&nbsp;Login</button> <a class="button" href="{{$base_url}}login/forget_password_view">Forgotten password?</a>
				</form>
				@else
					<p id='loggin-temp'>User Name:&nbsp;{{$username}} &nbsp;&nbsp;<a href="{{$base_url}}login/sign_out">Sign Out</a></p>
				@endif
			</div>
			<div class="footer">&raquo; <a href="<?php echo base_url(); ?>">Back To Site</a></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{{$base_url}}asset/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/js/bootstrap3.min.js"></script>
</body>
</html>