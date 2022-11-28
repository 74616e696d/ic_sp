<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>{{isset($title)?$title:"BCS &amp; BANK Job Preparation"}} || Iconpreparation</title>
  
  <?php
  $str_meta='';
  $str_meta.="<meta name='description' content='BCS &amp; Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 35th Questions and solutions are available here. People can study all materials and take model tests for BCS &amp; Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job.' />";
    $str_meta.="<meta name='keyword' content='37 BCS, 37th BCS, All BCS questions and solutions, 35th BCS questions and solutions, Bank questions and solutions, Bank jobs in Bangladesh, Bangladesh Bank AD questions and solutions, Bangladesh Bank job questions, Bank job questions, BCS written, Android app for Bank job, Android App for BCS, Current Affairs, Exim Bank questions and solutions, Agrani Bank Questions 2015, Trust Bank Questions, Sonali Bank Questions and Solutions, General Knowledge for BCS, Computer Questions for Bank Jobs, Puabli Bank Questions and Solutions, Krishi Bank Questions and Solutions, Bank Job questions, BCS Model Test,BCS, NTRCA, Bank Job, Bank recruitment, Bangladesh gov't Job, PSC Job, Bangladesh Judicial Service, BCS Question Bank, Bank Question, Bank Job Question, BCS question and solution, BCS exam, BCS Preliminary, BCS written, Bank Job question and solutions, NTRCA question, NTRCA question and solution, PSC question, Engineering Job question, NTRCA Model Test, How to prepare for BCS, How to Prepare for NTRCA, How to Prepare for Bank Job' />";
  ?>
  @yield('meta_tags',$str_meta)

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  
  <link rel="shortcut icon" href="<?php echo $base_url(); ?>asset/frontend/img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo $base_url(); ?>asset/frontend/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation library for notifications   -->
    <link href="{{ $base_url }}asset/expert/theme/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ $base_url }}asset/expert/theme/css/dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ $base_url }}asset/expert/theme/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ $base_url }}asset/expert/theme/css/themify-icons.css" rel="stylesheet">

    <style>
      .logo img{
        width: 100%;
      }
    </style>

    @yield('style')

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="black" data-active-color="danger">
      @include('master.left')
    </div>

    <div class="main-panel">
         @include('master.top')


        <div class="content">
            <div class="container-fluid">
                @yield('summery')
                <div class="row">
                    @yield('content')
                </div>
            
            </div>
        </div>


       @include('master.footer')

    </div>
</div>


</body>

    <!--   Core JS Files   -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="<?php echo $base_url(); ?>asset/expert/theme/js/bootstrap.min.js"></script>

  <!--  Checkbox, Radio & Switch Plugins -->
  <script src="{{ $base_url }}asset/expert/theme/js/bootstrap-checkbox-radio.js"></script>

    <!--  Notifications Plugin    -->
  <script src="{{ $base_url }}asset/expert/theme/js/bootstrap-notify.js"></script>
  <script src="{{ $base_url }}asset/expert/theme/js/dashboard.js"></script>

@yield('script')
 

</html>