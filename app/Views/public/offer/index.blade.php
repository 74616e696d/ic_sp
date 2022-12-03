<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>37th BCS, NTRCA, PSC and Government and Private Bank Job Preparation| Iconpreparation</title>
	<meta name="description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Question bank, solution, chapterwise discussion and questions are available for BCS, PSC job, Bank job, NTRCA job. Expert instructors are there to support the candidates to make an excellent preparation for job test." />
	<meta name="keyword" content="37 BCS, 37th BCS, BCS questions and solutions, BCS question Bank, Bank questions and solutions, Bank jobs in Bangladesh, Bangladesh Bank AD questions and solutions, Bangladesh Bank job questions, Bank job questions, BCS written, Android app for Bank job, Android App for BCS, Current Affairs, Exim Bank questions and solutions, Agrani Bank Questions 2016, Trust Bank Questions, Sonali Bank Questions and Solutions, General Knowledge for BCS, Computer Questions for Bank Jobs, Puabli Bank Questions and Solutions, Krishi Bank Questions and Solutions, Bank Job questions, BCS Model Test" />
	<meta property="og:url" content="http://iconpreparation.com/offer" /> 
	<meta property="og:type" content="article" /> 
	<meta property="og:title" content="IMPROVE YOUR PREPARATION FOR 37th BCS, NTRCA, PSC and Government and Private Bank Job Recruitment Test." /> 
	<meta property="og:description" content="BCS &amp; Bank Job Preparation provided by Iconpreparation. Question bank, solution, chapterwise discussion and questions are available for BCS, PSC job, Bank job, NTRCA job. Expert instructors are there to support the candidates to make an excellent preparation for job test." /> 
	<meta property="og:image" content="{{ $base_url }}asset/frontend/img/offer-header1-lg.jpg" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{$base_url}}asset/frontend/img/favicon.ico" type="image/x-icon">	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300,100italic,100,900' rel='stylesheet' type='text/css'>
	<link href="{{$base_url}}asset/frontend/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/vendor/flipclock/flipclock.css">
	<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/offer.css">
	<style>
		html.body{
			margin:0;
			padding: 0;
			background: #3498DB !important;
		}
		.table caption{
			font-size: 18px;
		}
		.table th,.table td{
			font-size: 16px;
		}
		h1,h2,h3,h4{line-height: 30px;}
		.box{
			background:#fff;
			padding:25px;
		}
		.top-bg{
			/*background-color: #3498DB;*/
			padding-top: 40px;
			padding-bottom: 40px;
			padding-left: 0;
			padding-right: 0;
		}
		.bottom-bg{
			background-color: #fff;
			padding: 20px;
		}
		.well{
			background-color: #fff;
			min-height: 450px;
		}
		.label{
			display: inline-block;
			margin-bottom:3px;
			margin-right:2px;
		}
		.label-default{
			background-color: #d8d8d8;
			color:#000;
		}
		.navbar-default{
			background:#fff;
			border:0;
			margin-bottom: 0;
		}
		.nav.navbar-nav.navbar-right.navbar-home {
		  padding-top: 17px;
		}
		.navbar-nav > li > a {
		  padding-bottom: 6px !important;
		  padding-top: 6px !important;
		  background: #fff;
		  color: #0177BF !important;
		}
		footer {
		  background: #064f94 none repeat scroll 0 0;
		  color: #fff;
		  padding: 15px 20px;
		}
		.footer-list li h4 {
		  color: #36abc2;
		  font-size: 19px;
		  padding-left: 0;
		}
		.footer-list li a {
		  color: #fff;
		  font-size: 14px;
		  line-height: 32px;
		  text-decoration: none;
		}

		.footer-social .social-facebook, .footer-social .social-youtube, .footer-social .social-twitter, .footer-social .social-gplus, .footer-social .social-linkedin {
		  box-shadow: 0 0 0 #ccc;
		  color: #fff;
		  margin-right: 5px;
		}

		.footer-social .social-facebook:hover, .footer-top .footer-social .social-youtube:hover, .footer-top .footer-social .social-twitter:hover, .footer-top .footer-social .social-gplus:hover, .footer-top .footer-social .social-linkedin:hover {
		  box-shadow: none;
		  color: #fff !important;
		}
	</style>
</head>
<body>
@include('front_master.top_menu')
<div class="container-fluid" style='background:#3498DB !important;overflow: hidden; '>
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-bg">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="well">
				<h2 class='text-center text-danger'>40 Days Package!!</h2>
				<h3 class='text-center'>@500 Tk. Only</h3>
				<h3 class='text-center'>BCS 37th Preliminary Preparation</h3>

				<h4 class='text-center'>A Complete Guideline to Pass the Preliminary Test!</h4>
				
				<hr>
				<div class="clock" style="margin:1em;margin-left:0"></div>
				<div class="message"></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="well">
				<table class="table table -bordered table-striped">
				<caption>Our Study Plan</caption>
					<thead>
						<tr>
							<th>Day</th>
							<th>Study</th>
							<th width="25%">Model Test</th>
						</tr>
					</thead>
					<tbody>
					@if($roadmap)
					<?php $day=1; ?>
					@foreach($roadmap as $row)
						<?php $tags=roadmap_details_model::chapter_tag($row->id); ?>
						<tr>
							<td>{{ $day }}</td>
							<td>
								@if($tags)
								@foreach($tags as $tag)
								<span class="label label-default">{{ $tag->name }}</span>
								@endforeach
								@endif
							</td>
							<td>{{ $row->exam_name }}</td>
						</tr>

					<?php $day++; ?>
					@endforeach
					@endif
					</tbody>
				</table>
				
				<a style='color:#444;text-decoration:none;margin:0 auto !important;text-align: center;display:block;'>
				<u > Please register to view the total preparation roadmap!</u></a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class='container-fluid'>
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bottom-bg">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 offer-right">
					<h2>Register Now</h2>
					<form action="<?php echo base_url(); ?>public/user_reg/add" method='post' style='margin-top:20px;padding-top: 5px;border:1px solid #dfdfdf;padding:20px;'>
						@if($ci->session->flashdata('error'))
						<?php $type=$ci->session->flashdata('action_type'); ?>
						@if($type!='login')
						{{render_message()}}
						@endif
						@endif
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" name="txt_email" id="txt_email"  class="form-control txt-plain" value="<?php echo old_value('email'); ?>" required />
						</div>
						<div class="form-group">
							<label for="">Mobile</label>
							<input type="text" name="txt_mobile" id="txt_mobile" value="<?php echo old_value('phone'); ?>" required class="form-control txt-plain">
						</div>
						<div class="form-group">
							<label for="">Password</label>
							<input type="password" name="txt_pass" id="txt_pass"  required class="form-control txt-plain">
						</div>
						<div class="form-group">
							<label for="">Re Type Password</label>
							<input type="password" name="txt_pass_retype" id="txt_pass_retype" required class="form-control txt-plain">
							<span class='pass_conf_msg'></span>
						</div>
						<div class="form-group">
							<button type="submit" class='btn btn-danger'>Sign Up</button>
						</div>
					</form>

				<!-- 	<div class="footer-social">
							            <h3>Follow us on</h3>
							            <a href="https://www.facebook.com/iconpreparation" class="btn btn-social social-facebook" target="_blank">
							            <i class="fa fa-facebook"></i></a>
							            <a href="https://www.youtube.com/channel/REPLACEFUTURE" class="btn btn-social social-youtube" target="_blank"><i class="fa fa-youtube"></i></a>
							            <a href="https://twitter.com/iconpreparation" class="btn btn-social social-twitter" target="_blank">
							            <i class="fa fa-twitter"></i></a>
							            <a href="https://plus.google.com/u/0/112685958483978255898/posts" class="btn btn-social social-gplus" target="_blank"><i class="fa fa-google-plus"></i></a>
							            <a href="https://www.linkedin.com/in/iconpreparation
							            " class="btn btn-social social-linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
				</div> -->
					<div class="btn-group btn-group-justified" role="group" aria-label="...">
						<div class="btn-group" role="group">
							<a href="" class="btn btn-danger">BCS</a>
						</div>
						<div class="btn-group" role="group">
							<a href="" class="btn btn-primary">BANK</a>
						</div>
						<div class="btn-group" role="group">
							<a href="" class="btn btn-warning">GOVT. JOB</a>
						</div>
						<div class="btn-group" role="group">
							<a href="" class="btn btn-info">MBA</a>
						</div>
					</div>
					<div>
						
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<h2>Iconpreparation at a Glance</h2>
					<hr>
					<ul class='list-feature'>
						<li>All Study Materials</li>
						<li>Previous Test(10th to 36th) Questions Explained</li>
						<li>Regular Updates of Current Affairs</li>
						<li>Expert Guidelines to Improve Preparation</li>
						<li>Study Progress Report</li>
						<li>See all your Mistakes and Learn again</li>
						<li>24/7 Support</li>
						<li>Easy and Quality Methods of Learning </li>
						<li>Monitored by ex students of IBA, BUET & Dhaka University</li>
					</ul>
				</div>
		</div>
	</div>
</div>

@include('front_master.footer')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ $base_url }}asset/frontend/js/jquery-1.10.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{$base_url}}asset/frontend/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ $base_url }}asset/vendor/flipclock/flipclock.min.js"></script>

<script type="text/javascript">
$(document).ready(function($) {
	var clock;
	clock = $('.clock').FlipClock({
        clockFace: 'DailyCounter',
        autoStart: false,
        callbacks: {
        	stop: function() {
        		$('.message').html('37 BCS Already Expired !')
        	}
        }
    });
    var tmNow=Date.now();
	var tm=new Date(2016,8,30,9,0,0).getTime(); 
	var diff=tm-tmNow;  
    console.log(tmNow);
    console.log(diff);
    clock.setTime(diff/1000);
    clock.setCountdown(true);
    clock.start();
});
</script>
</body>
</html>
