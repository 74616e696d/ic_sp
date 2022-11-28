<!Doctype html>
<html>
	<head>
		<title>Online Exam|<?php if($title)echo $title; ?></title>
		<link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>asset/css/prettyCheckable.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url(); ?>asset/css/quiz.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/prettyCheckable.js"></script>
	</head>
	<body>
		<div id="wrapper" class="container-fluid">
			<div id="header" class="row-fluid">
                <h1>Online Exam</h1>
			</div>
			<div id="main">
			<?php $this->load->view($main_content,$sub_content=null); ?>
			</div>
			<div id="footer">
			</div>
		</div>

	</body
</html>



