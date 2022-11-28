<!Doctype html>
<html ng-app>
<head>
    <meta charset="utf-8">
    <title>Online Exam</title>
    <link href="<?php echo base_url(); ?>asset/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>asset/css/custom/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/font-awesome-ie7.min.css">
    <![endif]-->
  <!--   <link href="<?php echo base_url(); ?>asset/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" /> -->
   <!--  <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen"> -->
    <link href="<?php echo base_url(); ?>asset/admin/css/styles.css" rel="stylesheet" media="screen">
    <script src="<?php echo base_url(); ?>asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
  	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.8.14.custom.min.js"></script>
  	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/angular.min.js"></script>
  	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/angular-dragdrop.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script> -->
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap2.min.js"></script>
</head>
<body>
<?php $this->load->view('layout_admin/top_menu'); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php $this->load->view('layout_admin/sidebar'); ?>

<!--/span-->
<div class="span9" id="content">
<!-- morris stacked chart -->
<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><?php if($title)echo $title;  ?> </div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <?php $this->load->view($main_content,$sub_content=false); ?>

            </div>
        </div>
    </div>
    <!-- /block -->
</div>

</div>
</div>
<hr>
<footer>
    <p>&copy; revinr 2013</p>
</footer>
</div>
<!--/.fluid-container-->
</body>

</html>