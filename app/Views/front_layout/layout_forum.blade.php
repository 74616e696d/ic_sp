<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Iconpreparation</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/asset/frontend/img/favicon.ico" type="image/x-icon">	
    <!-- CSS Files -->
	<link rel="stylesheet" href="/asset/frontend/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/asset/frontend/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/asset/frontend/css/style.css" />
	<link rel="stylesheet" href="/asset/frontend/css/animate.min.css" />
	<!-- <link rel="stylesheet" href="{{base_url()}}asset/frontend/css/custom.css"> -->
	<!-- / CSS Files -->
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/asset/frontend/css/custom.css">
    <style>
   .btn-group, .btn-group-vertical {
          cursor: pointer;
          display: inline-flex;
          padding-left: 10px;
          padding-top: 12px;
        }
        .sign-in
        {
            margin-right:5px;
        }
    </style>

    @yield('style')

    <!--Start of Zopim Live Chat Script-->
    <script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
    d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
    $.src='//v2.zopim.com/?2RQ4iV0FsLNwkgMO5M9MW1lDR43YFUaD';z.t=+new Date;$.
    type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
    </script>
    <!--End of Zopim Live Chat Script-->
</head>
<body>
<script type="text/javascript">
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1167642756586290";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<!-- top menu start -->
@include('front_layout.topmenu')
<!-- top menu end -->


<!-- page content start -->
@yield('content')
<!-- page content end -->


<!-- footer start -->
@include('front_layout.footer')
<!-- footer end -->

<!-- JavaScript Files -->
<script src="{{base_url()}}asset/frontend/js/jquery-1.10.2.min.js"></script>
<script src="{{base_url()}}asset/frontend/js/bootstrap.min.js"></script>
<script src="{{base_url()}}asset/frontend/js/animate.js"></script>
<!-- <script src="{{base_url()}}asset/frontend/js/jquery.easypiechart.min.js"></script> -->
<script src="{{base_url()}}asset/frontend/js/jquery.cuteTime.min.js"></script>
<script src="{{base_url()}}asset/frontend/js/script.js"></script>
<script type="text/javascript">
$(function () {
    $('.dropdown-menu input').click(function (event) {
        event.stopPropagation();
    });
});
</script>

@yield('script')
<!-- JavaScript Files -->
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