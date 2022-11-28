<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{isset($title)?$title:"BCS &amp; BANK Job Preparation"}} || Iconpreparation</title>
        <meta name="description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 35th Questions and solutions are available here. People can study all materials and take model tests for BCS &amp; Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job." />
        <meta name="keyword" content="37 BCS, 37th BCS, All BCS questions and solutions, 35th BCS questions and solutions, Bank questions and solutions, Bank jobs in Bangladesh, Bangladesh Bank AD questions and solutions, Bangladesh Bank job questions, Bank job questions, BCS written, Android app for Bank job, Android App for BCS, Current Affairs, Exim Bank questions and solutions, Agrani Bank Questions 2015, Trust Bank Questions, Sonali Bank Questions and Solutions, General Knowledge for BCS, Computer Questions for Bank Jobs, Puabli Bank Questions and Solutions, Krishi Bank Questions and Solutions, Bank Job questions, BCS Model Test" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:url" content="http://iconpreparation.com/" /> 
        <meta property="og:type" content="article" /> 
        <meta property="og:title" content="IMPROVE YOUR PREPARATION FOR BCS, Govt. &amp; BANK JOB." /> 
        <meta property="og:description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 35th Questions and solutions are available here. People can study all materials and take model tests for BCS &amp; Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job." /> 
        <meta property="og:image" content="{{ $base_url }}asset/frontend/new/img/mobile.png" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="shortcut icon" href="{{$base_url}}asset/frontend/img/favicon.ico" type="image/x-icon">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300,100italic,100,900' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <link href="{{$base_url}}asset/frontend/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{$base_url}}asset/frontend/new/css/style.css">
       <style>
       .menu-module li a:hover{
           cursor: pointer;
       }
       .ribbon-icon{
           top:95%;
       }
       .footer-list li{

       }
       .footer-list li a{
           color:#fff;
           text-decoration: none;
           font-size: 14px;
           line-height: 32px;
       }
       .footer-list li h4{
           padding-left: 0;
           color:#fff;
           font-size: 18px;
       }
       .footer-line{
               display: block;
             height: 1px;
             border: 0;
             border-top: 1px solid #2290D4;
             margin: 1em 0;
             padding: 0; 
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
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <div id="fb-root"></div>
    <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=340664209421681";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
<!-- start wrapper -->
    <div class="wrapper">

    <!-- START TOP MENU -->
    @include('front_master.top_menu')
    <!-- END TOP MENU -->

    <!-- START CONTENT -->
    @yield('content')
    <!-- END CONTENT -->

    <!--START FOOTER -->
    @include('front_master.footer')
    <!-- END FOOTER -->
</div> <!-- end wrapper -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{$base_url}}asset/frontend/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".menu-module li a").click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(".module-header").offset().top
            }, 2000);
            activaTab($(this).data('module'));
        });
    });
    function activaTab(tab)
    {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    }
    </script>
    @yield('script')
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