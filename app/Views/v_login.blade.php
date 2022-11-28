<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>Iconpreparation | Login</title>
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
	font-size:13px;
	padding: 8px 35px 8px 14px;
	/*text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);*/
}
.footer{
	color: #444 !important;
	text-align: left !important;
}
.footer a{
	color:#444 !important;
}
.footer a:hover{
	color:#0177BF !important;
}
</style>
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
				<h2><img alt="logo" src="<?php echo $base_url(); ?>asset/frontend/new/img/logo-white.png"></h2>
				{{$msg}}
				{{ render_message()}}

				@if(!$authenticated)
				
				<form action="<?php echo base_url(); ?>login/sign_in" method="post">
					<label for="login">Email:</label>
					<input id="login" name="login" class="text" placeholder="Email" required="required" />
					<label for="pass">Password:</label>
					<input id="pass" name="pass" type="password" class="text" placeholder="passsword" required="required"/>
					<div class="sep"></div>
					<button type="submit"><i style="color:#F97307;" class="fa fa-check"></i>&nbsp;Login</button> <a class="button" href="<?php echo $base_url(); ?>login/forget_password_view">Forgotten password?</a>
				</form>
				@else
					<p id='loggin-temp'>User Name:&nbsp;{{$username}} &nbsp;&nbsp;<a href="<?php echo $base_url(); ?>login/sign_out">Sign Out</a></p>
				@endif
			</div>
			<div class="footer">&raquo; 
			<a href="<?php echo base_url(); ?>">
			Back To Site</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			New To Iconpreparation ? <a href="{{ $base_url }}public/user_reg">Register</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url(); ?>asset/js/bootstrap3.min.js"></script>
</body>
</html>
