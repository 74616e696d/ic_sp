<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online Exam||<?php if($title)echo $title; ?></title>
		<link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/custom/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/admin/css/style.css" rel="stylesheet" type="text/css"/>
		<!-- <link href="<?php echo base_url(); ?>asset/css/ajaxloader.css" rel="stylesheet" type="text/css"/> -->
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
		<!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.ajaxloader.1.5.1.min.js"></script> -->
		<!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        <script src="<?php echo base_url(); ?>asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	<body>
	<div id="wrapper" class="container-fluid">
		<div id="header" class="row-fluid hero-unit">
			<h1><a href="<?php echo base_url(); ?>" title="Online Exam">Online Exam</a></h1>
		</div>
		<div id="main" class="row-fluid">
		<!--title-->
		<?php $this->load->view('layout_admin/title'); ?>
		<!--end title-->
		<?php $this->load->view('layout_admin/leftmenu'); ?>
		<!--end left content-->
		<!--right content-->
		<div id="right" class="span9">
		<?php $this->load->view($main_content,$sub_content=false); ?>
		</div>
		<!--end right content-->
		</div>
		
		<!--footer content-->
		<div id="footer" class="row-fluid">
		&copy; 2012 N@zrul
		</div>
		<!--end footer content-->
	</div>
	</body>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.10.0.custom.min.js"></script>
</html>