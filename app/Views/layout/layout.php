<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php if($title){echo $title;} ?> | Pinacle Test</title>
<!--    <link rel="shortcut icon" href="--><?php //echo base_url(); ?><!--/images/icons/favicon.ico"/>-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.default.css" type="text/css"/>
  <!--   <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap3.min.css" type="text/css"/> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.slimscroll.js"></script>

<!--    <script type="text/javascript" src="--><?php //echo base_url(); ?><!--js/custom/dashboard.js"></script>-->
    <!--[if lte IE 8]>
    <script language="javascript" type="text/javascript" src="js/plugins/excanvas.min.js"></script><![endif]-->
    <!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->



</head>
<body class="withvernav">

<div class="bodywrapper">

<?php include('topheader_ui.php'); ?>
<?php include('header_ui.php'); ?>
<?php include('left_menu_ui.php'); ?>

<!--start centercontent-->
<div class="centercontent">
<?php $this->load->view($main_content,$sub_content=null); ?>
</div>
<!--end centercontent -->
<div style='width:100%;clear:both;'></div>
<div id='footer'>
    <div class='footer-left'>
        <div class='footer-inner-left'>
            
        </div>
        <div class='footer-inner-right'>
            
        </div>
    </div>
    <div class='footer-right'>
        <div class='right-footer-inner-left'>
            
        </div>
        <div class='right-footer-inner'>
            
        </div>
        <div class='right-footer-inner-right'>
            
        </div>
    </div>
</div>
</div>
<!--bodywrapper-->
</body>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/custom/general.js"></script>
</html>
