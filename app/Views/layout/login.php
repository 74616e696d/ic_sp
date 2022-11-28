<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online Exam||<?php if($title)echo $title; ?></title>
		<link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/font-awesome-ie7.min.css">
        <![endif]-->
		<link href="<?php echo base_url(); ?>asset/css/style.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
		<!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]--> 
	<style type="text/css">
		.loginbox
		{
		color:white;
			width:40%;
			margin:20% auto;
			background-color:#3C003C;
			border-radius:10px;
			padding:3px;
		}
		.loginbox h2{
		font-size:16px;
		color:white;
		text-align:center;
		}
	</style>
	</head>
	<body>

	<div class="container-fluid">
		<div class="loginbox">
		<h2>Admin Login Area</h2>
			<form class="form-horizontal" method="post" action="<?php echo base_url();?>index/login_action">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" name="txtemail" id="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" name="txtpassword" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Remember me
      </label>
      <button type="submit" class="btn">Sign in</button>
    </div>
  </div>
</form>
		</div>
	</div>
	</body>
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>