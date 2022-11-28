<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Iconpreparation</title>
    <link href="{{$base_url}}asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{$base_url}}asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="{{$base_url}}asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="{{$base_url}}asset/css/font-awesome-ie7.min.css">
    <![endif]-->
  <link href="{{$base_url}}asset/css/custom/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
   <!--  <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen"> -->
    <link href="{{$base_url}}asset/admin/css/styles.css" rel="stylesheet" media="screen">
    <style>
    #sidebar_toggle i
    {
    	cursor:pointer;
    }
    </style>
    @yield('style')
    <script src="{{$base_url}}asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript" src="{{$base_url}}asset/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="{{$base_url}}asset/js/jquery-ui-1.10.0.custom.min.js"></script>
    <!-- <script type="text/javascript" src="{{$base_url}}asset/js/bootstrap.min.js"></script> -->
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <script type="text/javascript" src="{{$base_url}}asset/js/bootstrap2.min.js"></script>
</head>
<body>
@include('admin_master.topmenu')
<div class="container-fluid">
<div class="row-fluid">
@include('admin_master.sidebar')
<!--/span-->
<a href="{{ $base_url }}university/admin/dashboard" class="btn btn-primary btn-small"><i class="fa fa-switch"></i>Switch To University Dashboard</a>

<a href="{{ $base_url }}school/admin/dashboard" class="btn btn-info btn-small"><i class="fa fa-switch"></i>Switch To School Dashboard</a>
<div class="span9" id="content">
<!-- morris stacked chart -->
<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><a id='sidebar_toggle'>
            <i class='fa fa-bars'></i></a></a> @if($title){{$title}}@endif</div>
        </div>
        <div class="block-content collapse in">
            <!-- <div class="span12"> -->
                {{render_message()}}
                @yield('content')

            <!-- </div> -->
        </div>
    </div>
    <!-- /block -->
</div>

</div>
</div>
<hr>
<footer>
    <p>&copy; revinr {{date('Y')}}</p>
</footer>
</div>
<!--/.fluid-container-->

@yield('script')
<script type='text/javascript'>
$(document).ready(function() {
	$('#sidebar_toggle').click(function(){
		$('#sidebar').toggle('slow','swing');
		$('#content').toggleClass('span9','span12');
	});
});
</script>

<script>
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-55677449-1', 'auto');
 ga('send', 'pageview');

</script>
</body>

</html>