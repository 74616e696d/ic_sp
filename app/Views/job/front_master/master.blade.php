<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Iconpreparation Jobs</title>
        <meta name="description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 35th Questions and solutions are available here. People can study all materials and take model tests for BCS &amp; Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job." />
        <meta name="keyword" content="36 BCS, 36th BCS, All BCS questions and solutions, 35th BCS questions and solutions, Bank questions and solutions, Bank jobs in Bangladesh, Bangladesh Bank AD questions and solutions, Bangladesh Bank job questions, Bank job questions, BCS written, Android app for Bank job, Android App for BCS, Current Affairs, Exim Bank questions and solutions, Agrani Bank Questions 2015, Trust Bank Questions, Sonali Bank Questions and Solutions, General Knowledge for BCS, Computer Questions for Bank Jobs, Puabli Bank Questions and Solutions, Krishi Bank Questions and Solutions, Bank Job questions, BCS Model Test" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php 
          $default_meta='';
          $default_meta.='<meta property="og:url" content="http://iconpreparation.com/" />'."\r\n";
          $default_meta.='<meta property="og:type" content="article" />'."\r\n";
          $default_meta.='<meta property="og:description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 35th Questions and solutions are available here. People can study all materials and take model tests for BCS &amp; Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job." />'."\r\n";
          $default_meta.='<meta property="og:image" content="' . base_url('asset/frontend/new/img/mobile.png') . '" />'."\r\n";
        ?>
        
        @yield('fbmeta',$default_meta)
        <link rel="shortcut icon" href="{{$base_url}}asset/frontend/img/favicon.ico" type="image/x-icon">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300,100italic,100,900' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <link href="/asset/frontend/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/asset/css/font-awesome.min.css">
        <link rel="stylesheet" href="/asset/job/css/jquery.bxslider.css">
        <link rel="stylesheet" href="/asset/job/css/style.css">
        <link rel="stylesheet" href="/asset/job/css/job_circular.css">
        <link rel="stylesheet" href="/asset/job/theme/css/job.css">
        <style>
            .footer-list li a{
                text-decoration: none;
                font-size: 14px;
                line-height: 32px;
                color: #fff;
            }

        </style>
        @yield('style')
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
        <div class="wrapper">
<!-- START TOP MENU -->
<nav class="navbar navbar-default" role="navigation">

    <div class="container container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
            <img class="img-responsive" src="/asset/frontend/new/img/logo.png" alt="Iconpreparation">
            </a>
        </div>
      <!--   Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right navbar-home">
                <li><a href="/">Home</a></li>
                <li><a href="/job/job_list">Jobs</a></li>
                <li><a href="/current_news">Current News</a></li>
                <li><a href="/forum/posts">Forum</a></li>
                <li ><a href="/public/user_reg" class='btn btn-primary btn-sm btn-login'>SIGN UP</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div>
</nav>
<!-- END TOP MENU -->
<!-- <br> -->
<!-- START CONTENT -->
@yield('content')
<!-- END CONTENT -->

<!-- START FOOTER -->
@include('front_master.footer')
<!--END FOOTER -->
</div>
<!--end wrapper -->

<script type="text/javascript" src="/asset/job/db/jquery/jquery.min.js"></script>
<script src="/asset/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function($) {
        // $(".navbar-home li:nth-child(2)").click(function(e) {
        //     e.preventDefault();
        //     $('html, body').animate({
        //         scrollTop: $(".module-header").offset().top
        //     }, 2000);
        // });
    });
</script>
<script type="text/javascript" src="/asset/job/js/jquery.bxslider.min.js"></script>
@yield('script')
    </body>
</html>