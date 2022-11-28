<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	  <!--[if IE 7]>
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/font-awesome-ie7.min.css">
	  <![endif]-->
	<link href="<?php echo base_url(); ?>asset/css/custom/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
	 <!--  <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen"> -->
	  <link href="<?php echo base_url(); ?>asset/admin/css/styles.css" rel="stylesheet" media="screen">
	  <script src="<?php echo base_url(); ?>asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.10.0.custom.min.js"></script>
	  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script> -->
	  <!-- HTML5 shim for IE backwards compatibility -->
	  <!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	  <![endif]-->
	  
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap2.min.js"></script>

</head>
<body>
{{$qlist}}


<script type="text/javascript">
	$(document).ready(function() {
		$('a.delete_ques').click(function(e){
			e.preventDefault();
			var id=$(this).data('id');
			var conf=confirm('are you sure to delete??');
			var present=$(this);
			if(conf)
			{
				$.ajax({
					url: '{{$base_url}}admin/ques_to_comprehension/delete_assigned_ques',
					type: 'GET',
					data: {id:id},
				})
				.done(function(data) {
					present.parent('li').remove();
				});
				
			}

		});
	});
</script>

</body>

</html>