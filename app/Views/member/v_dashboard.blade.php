<?php
use App\Models\Ref_text_model;
$this->refTextModel = new Ref_text_model();
?>

@extends('master.layout')

@section('content')

<div class="row">
	<div class="col-sm-6 right-zero-pad">
		
		<!-- ongoing course -->
		<div class="bx bx-referral">
			<div class="bx bx-header">
				<h4 class="bx-title">Quick Courses</h4>
				<div class="colps">
	            	<a href=""><i class="fa fa-angle-up"></i></a>
	          	</div>
			</div>
			<div class="bx bx-body">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<ul class="list-group">
									
					<li class="list-group-item">
							 <a href="{{$base_url}}member/cexam" style='color:red;font-weight: bold;'>
							    <span> <i class="menu-icon fa fa-bolt"></i>43rd BCS Preliminary</span>
							  </a>
						</li>
<li class="list-group-item">
							 <a href="{{$base_url}}member/cexam/inception" style='color:red;font-weight: bold;'>
							    <span> <i class="menu-icon fa fa-bolt"></i>BCS & BANK COMBINED MODEL TEST</span>
							  </a>
						</li>


					{{--
<li class="list-group-item">
							 <a href="{{$base_url}}member/cexam/ntrca" style='color:red;font-weight: bold;'>
							    <span> <i class="menu-icon fa fa-bolt"></i>17TH NTRCA</span>
							  </a>
						</li>

					 --}}	
					
					</ul>
				</div>

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<ul class='list-group'>

						
						<li class="list-group-item">
							 <a href="{{$base_url}}member/cexam/primary_school" style='color:red;font-weight: bold;'>
							    <span> <i class="menu-icon fa fa-bolt"></i>PRIMARY SCHOOL TEACHER</span>
							  </a>
						</li>
						<li class="list-group-item">
						    <a href="{{$base_url}}member/cexam_bank/ongoing" style='color:red;font-weight: bold;'>
						    <span> <i class="menu-icon fa fa-bolt"></i>Bangladesh Bank AD Crash Program</span>
						    </a>
						</li>
					</ul>
				</div>

				<div class="clearfix"></div>
				
			</div>
		</div>
		<!-- end ongoing course -->

		<!-- share with friends -->
		<div class="bx bx-referral hide">
			<div class="bx bx-header">
				<h4 class="bx-title">Share With Your Friends.  </h4>
				<div class="colps">
	            	<a href=""><i class="fa fa-angle-up"></i></a>
	          	</div>
			</div>
			<div class="bx bx-body div_ref_offer">
				<div class="row auto_mar div_ref_offer">
				    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<h2 class='bg-primary'>Get 1 Week Full Access <span style='color:#ffe400'>For 1 Friend Registration</span> From Your Reference. </h2>
				      <a id='btnInvite' href="{{ $refereal_url }}" data-title='Iconpreparation is an awesome platform for BCS, Bank Job, NTRCA and all types of job Preparation. ' data-desc='Register now to learn, prepare and improve yourself.' data-image='{{ $base_url }}asset/frontend/new/img/preview.jpg' class='btn btn-info btn-lg'>Invite Your Friends</a>
				    </div>
				</div>
				
			</div>
		</div>
		<!-- end share with friends -->

		<!-- START UPGRADE MEMBERSHIP -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">My Membership plan</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
					<ul class="list-unstyled">
					@if($mtype==2)
					<li>
					<h5 style='color:#0C7CB3;font-size:18px;'>আমি Basic membership ব্যবহার করছি</h5>
					</li>
					{{-- <li>
						<img width="530" class="img-responsive" src="{{$base_url}}asset/member/img/plan.jpg" alt="Plan">
					</li> --}}
					@endif
					<li>
					{{ $message_for_member }}
					</li>
					<li>&nbsp;</li>
					<li style='padding-left:10px;'>	
						<a id="sendEmail" href="{{$base_url}}public/upgrade" class="pull-right btn btn-default btn-sm">
							Upgrade Now
							</a>
							<div class="clearfix"></div>
						</i>
						</a>
					</li>
					</ul>
			</div>
		</div>
		<!-- END UPGRADE MEMBERSHIP -->

		<!-- users choice -->
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Plan Your Reading</h4>
				<div class="colps">
	            	<a href=""><i class="fa fa-angle-up"></i></a>
	          	</div>
			</div>
			<div class="bx bx-body bx-event">
				@include('member.plan.plan')
			</div>
		</div>
		<!-- end users choice -->

		<!-- on going  class -->
		<?php $trimmed_ongoing_events=trim($ongoing_events); ?>
		@if(!empty($trimmed_ongoing_events))
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">On Going Classes</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body bx-event">
			{{$ongoing_events}}
			
			</div>
		</div>
		@endif
		<!-- end ongoing  class -->

		<!-- start offer -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">How to use</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
				<ul class="list-group">
					<li class="list-group-item">Read &amp; Practice এ গিয়ে আপনার Category সিলেক্ট করে অধ্যায় ভিত্তিক আলোচনা ও প্রশ্ন পড়ুন। অধ্যায়ভিত্তিক কুইজ দিন যতবার খুশি। যে প্রশ্ন </li>
					<li class="list-group-item">Previous Job Test এ গিয়ে বিগত সালের প্রশ্ন ও উত্তর দেখুন।  নিজেও  পরীক্ষা দিয়ে যাচাই করে নিন নিজেকে </li>
					<li class="list-group-item">Model Test এ গিয়ে আপনার Category সিলেক্ট করে মডেল টেস্ট দিন।  </li>
					<li class="list-group-item"> My Statistics  গিয়ে পরীক্ষার উত্তর  দেখুন। </li>
					<li class="list-group-item"> Mistake List এ গিয়ে আপনার  ভুলগুলো দেখে ঠিক করে নিন।  </li>

				</ul>
				
			</div>
		</div>
		<!-- end offer -->


		<!-- start offer -->
		<!-- <div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">25% discount on package upgrade</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
				<img src="{{$base_url}}asset/frontend/img/offer.jpg" alt="" class="img-responsive">
			</div>
		</div> -->
		<!-- end offer -->

		<!-- start banner -->

		<!-- end banner -->

		<!-- start 
		 now -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">Read &amp; Practice</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
				  <li role="presentation" class="active">
				  <a href="#home" aria-controls="home" role="tab" data-toggle="tab">BCS</a>
				  </li>
				  <li role="presentation">
				  <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">BANK</a>
				  </li>
				  <li role="presentation">
				  <a href="#bcswritten" aria-controls="bcswritten" role="tab" data-toggle="tab">NTRCA কলেজ </a>
				  </li>

				  <li role="presentation">
				  <a href="#mba" aria-controls="mba" role="tab" data-toggle="tab">NTRCA স্কুল ২</a>
				  </li> 

				  <li role="presentation">
				  <a href="#nobondhon" aria-controls="nobondhon" role="tab" data-toggle="tab">
				  <!-- বেসরকারি  -->NTRCA স্কুল</a>
				  </li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div role="tabpanel" class="tab-pane active" id="home">
				  	<ul class="list-unstyled list-subject">
				  	@if($bcs_subject)
				  		@foreach($bcs_subject as $bcs)
				  		<li>
				  		 <a target='_blank' href="{{$base_url}}member/practice/index/7/{{$bcs->id}}">
				  		 <i class="fa fa-hand-o-right"></i>  {{$bcs->name}}</a> 
				  		</li>
				  		@endforeach
				  	@endif
				  	</ul>
				  </div>
				  <div role="tabpanel" class="tab-pane" id="profile">
				  	<ul class="list-unstyled list-subject">
				  	@if($bank_subject)
				  		@foreach($bank_subject as $bank)

				  		<li>
				  		<a target='_blank' href="{{$base_url}}member/practice/index/318/{{$bank->id}}">
				  		<i class="fa fa-hand-o-right"></i>  {{$bank->name}}</a> 
				  		</li>
				  		@endforeach
				  	@endif
				  	</ul>
				  </div>

				  <div role='tabpanel' class='tab-pane' id='bcswritten'>
				  <ul class="list-unstyled list-subject">
				  	@if($bcs_written)
				  	@foreach($bcs_written as $wrtn)
					<li>
						<a target='_blank' href="{{$base_url}}member/practice/index/1242/{{$wrtn->id}}">
						<i class="fa fa-hand-o-right"></i>  {{$wrtn->name}}</a>
					</li>
				  	@endforeach
				  	@endif
				  </ul>
				  </div>

				  <div role='tabpanel' class='tab-pane' id='mba'>
				  	  <ul class="list-unstyled list-subject">
				  	  	@if($mba)
				  	  	@foreach($mba as $m)
				  		<li>
				  			<a target='_blank' href="{{$base_url}}member/practice/index/1241/{{$m->id}}">
				  			<i class="fa fa-hand-o-right"></i>  {{$m->name}}</a>
				  		</li>
				  	  	@endforeach
				  	  	@endif
				  	  </ul>
				  </div>
				  <div role='tabpanel' class='tab-pane' id='nobondhon'>
				  	  <ul class="list-unstyled list-subject">
				  	  	@if($nibondhon)
				  	  	@foreach($nibondhon as $nbndn)
				  		<li>
				  			<a target='_blank' href="{{$base_url}}member/practice/index/1240/{{$nbndn->id}}">
				  			<i class="fa fa-hand-o-right"></i>  {{$nbndn->name}}</a>
				  		</li>
				  	  	@endforeach
				  	  	@endif
				  	  </ul>
				  </div>

				</div>
			</div>

			
			</div>
		</div>
		<!-- end study now -->
		
		<!-- START MISTAKE LIST -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">My Mistakes</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
			<h5 style='margin-top:0;color:#0C7CB3;'>প্র্যাকটিস করুন, পরীক্ষা দিন এবং Quiz এ অংশ নিন। যত ভুল করবেন সব এখানে দেখুন।</h5>
			<ul class="list-unstyled">
			{{$mistake_list}}
			<li>&nbsp;</li>
			<li>
				<a id="sendEmail" href="{{$base_url}}member/mistake_list" class="pull-right btn btn-default btn-sm">
				View All
				</a>
				<div class="clearfix"></div>
			</li>
			</ul>
			</div>
		</div>
		<!-- END MISTAKE LIST -->


		<!-- START EXPERT REVIEW -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">Expert Review</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
			{{-- <h5 style='margin-top:0;color:#0C7CB3;'>প্র্যাকটিস করুন, পরীক্ষা দিন এবং Quiz এ অংশ নিন। যত ভুল করবেন সব এখানে দেখুন।</h5> --}}
			<ul class="list-unstyled">
			@if(!empty($reviews))
			{{$reviews}}
			@else
			<li>No Expert Review Found</li>
			@endif
			<li>&nbsp;</li>
		{{-- 	<li>
				<a id="sendEmail" href="{{$base_url}}member/mistake_list" class="pull-right btn btn-default btn-sm">
				View All
				</a>
				<div class="clearfix"></div>
			</li> --}}
			</ul>
			</div>
		</div>
		<!-- END EXPERT REVIEW -->

		<!-- START REVIEWS -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">Reviews</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
			<h5 style='margin-top:0;color:#0C7CB3;'>যে সব প্রশ্ন আপনি ভুলে যেতে পারেন তা Review list এ Add করুন এবং এক ক্লিকে দেখে নিন।</h5>
			<ul class="list-unstyled">
			{{$review_list}}
			<li>&nbsp;</li>
			<li>
				<a href="{{$base_url}}member/review_list" class='pull-right btn btn-default btn-sm'>View All</i>
				</a>
				<div class="clearfix"></div>
			</li>
			</ul>
			</div>
		</div>
		<!-- END REVIEWS -->
		
		<!-- START LATEST EXAM -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">Latest Exam</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
				<div class="table-responsive">
					{{$user_latest_exam}}
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- END LATEST EXAM -->

		<!-- START PROGRESS OVERVIEW -->
		<div class="bx">
			<div class="bx bx-header">
			<h4 class="bx-title">Progress Overview</h4>
			<div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
          	</div>
			</div>
			<div class="bx bx-body">
			<ul class="nav nav-tabs" role="tablist" id="progressTab">
			  <li role="presentation" class="active">
			  <a href="#bcs" aria-controls="bcs" role="tab" data-toggle="tab">BCS</a>
			  </li>
			  <li role="presentation">
			  <a href="#bank" aria-controls="bank" role="tab" data-toggle="tab">Bank</a>
			  </li>
			</ul>

			
			</div>
				
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- END PROGRESS OVERVIEW -->
	</div>
	

	<div class="col-sm-6 right-zero-pad">
		<div class="col-sm-5 no-pad">
			<!--start upcoming class -->
			<?php $trimmed_upcoming_event=trim($events); ?>
			@if(!empty($trimmed_upcoming_event))
			<div class="bx">
				<div class="bx bx-header">
					<h3 class="bx-title">Upcoming Classes</h3>
				</div>
				<div class="bx bx-body bx-going-event">
					{{$events}}
				</div>
			</div>
			@endif
			<!-- end upcoming class -->

			<div class="bx">
				<div class="bx bx-header"><div class="bx-title"> Model Tests</div></div>
				{{--{{$latest_exams}}--}}

				 <div class='bx bx-body adv'>
				 	<?php 
				 	$now = date('Y-m-d H:i:s');
				 	?> 
					

					<ul class="list-unstyled">
					@if($live_test)
						<u> Live Test </u>

					@foreach($live_test as $row)
						<li style='line-height:50px;border-bottom:1px solid #f6f6f6;'>
		               
		               <h4>{{$row->name}}</h4>
		               {{ date('d Y M : hi A', strtotime($row->exam_time)) }}

		               <!-- <p>Question added</p> -->

		               @if($now >= $row->exam_time)
		               <a class='btn btn-default btn-xs' href='{{$base_url}}member/model_quiz/index/{{$row->id}}'>Start Now</a>
		               @endif
		              
		               </li>
						@endforeach
						<li>
							<a class="btn btn-link" href="{{$base_url}}member/model_test">View All Live</a>
						</li>

					@endif

					<br>
					<u>Other Model Tests </u>
					<br>
					@if($model_test)
						@foreach($model_test as $test)
						<li style='line-height:50px;border-bottom:1px solid #f6f6f6;'>
		               
		               <h4>{{$test->name}}</h4>
		               <!-- <p>Question added</p> -->
		               <a class='btn btn-default btn-xs' href='{{$base_url}}member/model_quiz/index/{{$test->id}}'>Start Now</a>
		              
		               </li>
						@endforeach
						<li>
							<a class="btn btn-link" href="{{$base_url}}member/model_test">View All</a>
						</li>
						</ul>
					</div>
					@endif
					
				<div class="bx bx-body adv">
					<a href="{{$base_url}}member/take_exam/index/318"><img src="{{$base_url}}asset/member/img/allbank.png" alt="All Bank Exams"></a>
				</div>
				<div class="bx bx-body adv">
					<a target="_blank" href="http://revinr.com"><img src="{{$base_url}}asset/frontend/img/revinr.png" alt="revinr.com"></a>
				</div>
			</div>
		</div>
	</div>
		<div class="col-lg-7 col-md-7">

			<div class="bx">
				<div class="bx bx-header">
					<h4 class="bx bx-title">Today's Words</h4>
				</div>
				<div class="bx bx-body" style="padding-left:0;padding-right:0">
						@if($vocabulary)
						<div class="word-container">
						@foreach($vocabulary as $v)
						<div class="word">
							<div class="card">
								<div class="front"> 
								   <h3>{{$v->word}}</h3>
								 </div> 
								 <div class="back">
								  <h4><strong>Meaning:&nbsp;&nbsp;</strong> {{$v->meaning}} </h4>
								   <strong>Synonyms:&nbsp;&nbsp;</strong>{{$v->synonyms}} <br>
								   <strong>Antonyms:&nbsp;&nbsp;</strong>{{$v->antonyms}} <br>
								   <strong>Example:&nbsp;&nbsp;</strong>{{$v->example}}
								 </div>
							</div>
						<!-- 	<ul class="list-unstyled word-list">
								<li><strong>Word:</strong>&nbsp;&nbsp; <label class="label label-primary">{{$v->word}}</label></li>
								<li><strong>Meaning:</strong>&nbsp;&nbsp;{{$v->meaning}}</li>
								<li><strong>Synonyms:</strong>&nbsp;&nbsp; {{$v->synonyms}}</li>
								<li><strong>Antonyms:</strong>&nbsp;&nbsp; {{$v->antonyms}}</li>
								<li><strong>Example:</strong>&nbsp;&nbsp;{{$v->example}}</li>
							</ul> -->
						</div>
						@endforeach
						</div>
						<ul class="pager">
							<li><a id='prev' href="" style='background:#ccc;color:#444;'>Prev</a></li>
							<li><a id='next' href="" style='background:#ccc;color:#444;'>Next </a></li>
						</ul>
						@endif
					
				</div>
			</div>


			<div class="bx">
				<div class="bx bx-header">
					<h4 class="bx bx-title">Iconpreparation Update</h4>
				</div>
				<div class="bx bx-body">
					<ul class='list-unstyled activity'>
					{{$activity_logs}}
					</ul>
				</div>
			</div>


			<!-- start profile -->
			<div class="bx">
				<div class="bx bx-header">
				<h4 class="bx-title">Profile Completed {{$profile_comp}}%</h4>
				<div class="colps">
	            <a href=""><i class="fa fa-angle-up"></i></a>
	          	</div>
				</div>
				<div class="bx bx-body">
					<ul class='list-unstyled'>
							<li style='width:70%;'>					
							<div title='Profile Completed {{$profile_comp}}%' data-toggle='tooltip' class="progressbar"></div>
							</li>
							<li>
								<a href="{{$base_url}}member/account_setting" class='pull-right btn btn-default btn-sm'>Update Now</a>
								<div class="clearfix"></div>
							</li>
						</ul>
				</div>
			</div> <!-- end profile -->
		</div>

	</div>
</div>
<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Create Study Plan</h4>
		</div>
		<div class="modal-body">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
		</div>
		</div>
	</div>
</div>



@stop

@section('style')
<link href="{{base_url()}}/punlic/asset/css/custom/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
<style>
	.frm-choice{
		padding:5px 5px;
	}
	.ck_read{
		margin-right:8px !important;
	}
	.sub-header a
	{
		color:#F37F2E;
		font-size: 19px;
	}
	.bx-event h4{
		font-size: 15px !important;
	}
	.badge-info
	{
		background: #0177BF;
	}
	.activity
	{

	}
	.activity li
	{
		font-size:14px;
		/*padding-top:4px;*/
		/*padding-bottom:4px;*/
	}
	.activity li span
	{
		font-size:12px;
		color:#BED0D0;
	}
	.activity li hr
	{
		margin-top:10px;
		margin-bottom:10px;
	}
	.carousel-fade .item {-webkit-transition: opacity 3s; -moz-transition: opacity 3s; -ms-transition: opacity 3s; -o-transition: opacity 3s; transition: opacity 3s;}
	.carousel-fade .active.left {left:0;opacity:0;z-index:2;}
	.carousel-fade .next {left:0;opacity:1;z-index:1;}
	.label
	{
		padding-top:5px;
		padding-bottom:5px;
		padding-left:7px;
		padding-right:7px;
		font-size:13px;
	}
	.pager
	{
		margin-top:0;
	}

	.pager li > a, .pager li > span {
	  background-color: #fff;
	  border: 1px solid #ddd;
	  border-radius: 10px;
	  display: inline-block;
	  padding: 5px 20px;
	}

	.icn-avg
	{
		display:block;
		width:12px;
		height:12px;
		background:#F4932A;	
		margin-top:3px;
		float:left;
	}
	.icn-top-score
	{
		width:12px;
		height:12px;
		margin-top:3px;
		background:#D8D95D;	
		float:left;

	}
	.icn-score
	{
		display:block;
		width:12px;
		height:12px;
		margin-top:3px;
		background:#0088CC;	
		float:left;

	}
	.word-container
	{
		width:100%;
		min-height: 200px;
		margin-bottom: 5px;
	}
	.word-list
	{
		line-height:25px;
	}
	.word
	{
		width: 100%;
		/*height:auto;*/
		min-height: 200px;
	}
	.card
	{
		width:100%;
		min-height: 200px;
	}
	.card>.front
	{
		padding: 10px;
	}
	.card>.front h3
	{
		text-align: center;
	}
	.card>.back
	{
		padding: 10px;
		background: #0784BA;
		color:#fff;
	}
	.card>.back h4{color:#fff;}

	.btn
	{
		border-radius:6px;
		box-shadow:none;
		border:none;
		
	}
	.btn-default
	{
		color:#555555 !important;
		background:#D1D1D1;
	}
	.progressbar {
	    color: #3C8DBC;
	    text-align: right;
	    height: 25px;
	    width: 0;
	    border-radius:5px;
	    background:#D8D8D8;
	}
	.list-subject{margin-top: 8px;}
	.list-subject li
	{
		line-height: 25px;
	}
	.list-subject li a
	{
		color: #000;
	}
	.list-subject li a:hover
	{
		color:#117AAE;
	}
	.dt{
		display: inline-block;
		width:75px;
	}
	.bx-referral .bx-header
	{
		margin-bottom: 0;
	}
	.div_ref_offer
	{
		background:#00688d;
		color:#fff;
		margin-left: 0 !important;
		margin-right: -10px !important;
	}
</style>
@stop

@section('script')
@include('member.offer')
<script type="text/javascript" src="{{base_url()}}/public/asset/js/jquery-ui-1.10.0.custom.min.js"></script>

<?php $avg_mark = 25; $top_score = 75; $my_score = 50; ?>
<script type="text/javascript" src="{{base_url()}}/public/asset/member/js/plugins/jquery.progressbar.min.js"></script>
<script type="text/javascript" src="{{base_url()}}/public/asset/member/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="{{base_url()}}/public/asset/vendor/flip/jquery.flip.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dtpick').datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat:'yy-mm-dd',
			showButtonPanel: true
		});
		$(".card").flip({
		  axis: 'x',
		  trigger: 'hover'
		});
		//update checkin status
		$('.check_in').click(function(){
			var that=$(this);
			var cnt=that.next('span');
			var count=Number(cnt.text());
			var status=that.data('status');
			var eid=that.data('event');
			$.ajax({
				url: '{{$base_url}}member/dashboard/update_check_in',
				type: 'GET',
				data: {status:status,eid:eid}
			})
			.done(function(res) {
				that.data('status',res);
				if(res=='1')
				{
					count=count-1;
					cnt.text(count);
					that.removeClass('btn-info').addClass('btn-default');	
				}
				else
				{
					count=count+1;
					cnt.text(count);
					that.removeClass('btn-default').addClass('btn-info');
				}
			});
			
		}); //update ckeckin status

		$('.word-container').cycle({
        	fx:'fade',
    	    timeout: 0, 
    	    next: '#next', 
    	    prev: '#prev' 
        });

		$('#progressTab').tab()

		$('.avg').css('margin-left','{{round($avg_mark)}}%');
		$('.top-score').css('margin-left','{{round($top_score)}}%');
		$('.score').css('margin-left','{{round($my_score)}}%');
		// $('.avg').css('margin-left','50%');
		// $('.top-score').css('margin-left','80%');
		// $('.score').css('margin-left','40%');
		
		$('.avg').mouseover(function(){
			$(this).attr('title','{{round($avg_mark)}}'+"%");
			$(this).tooltip({trigger:'manual'}).tooltip('show');
			
		});

		$('.top-score').mouseover(function(){
			$(this).attr('title','{{round($top_score)}}'+"%");
			$(this).tooltip({trigger:'manual'}).tooltip('show');
		});
		$('.score').mouseover(function(){
			$(this).attr('title','{{round($my_score)}}'+"%");
			$(this).tooltip({trigger:'manual'}).tooltip('show');
		});

		var bar=$('.progressbar').progressbar({width:'95%',color:'#3C8DBC',border:'1px solid #859DC3'});
		bar.progress({{$profile_comp}});

		//get subject by category
		$('#category').change(function(event) {
			var cat_id=$(this).val();
			$.ajax({
				url: '{{ $base_url }}member/dashboard/subject_list',
				type: 'GET',
				data: {cat_id:cat_id},
			})
			.done(function(res) {
				$('#subject').html(res);
			});
			
		});//end get subject by category

		$('#subject').change(function(event) {
			var subj_id=$(this).val();
			$.ajax({
				url: '{{ $base_url }}member/dashboard/get_chapters',
				type: 'GET',
				data: {subj_id: subj_id}
			})
			.done(function(res) {
				$('#chapter').html(res);
			});
		});

		//save users choice
		$('#plan_save').click(function() {
			var category=$('#category').val();
			var chapter=$('#chapter').val();
			var dt= $("#dtpick").val();
			$.ajax({
				url: '{{ $base_url }}member/dashboard/save_user_choice',
				type: 'POST',
				data: {category:category,chapter:chapter,dt:dt}
			})
			.done(function(res) {
				$('#choice_list').html(res);
			});
			
		});
		//end save users choice
		
		//update read status
		$('#choice_list').on('click', '.ck_read', function() {
			var choice=$(this).data('choice');
			var stat=$(this).is(':checked')?1:0;
			$.ajax({
				url: '{{ $base_url }}member/dashboard/update_read_status',
				type: 'GET',
				data: {choice:choice,stat:stat}
			})
			.done(function(res) {
				if(stat==1){
					$('#spn_choice_'+choice).text('Done');
				}
				else
				{
					$('#spn_choice_'+choice).text('Not Done');
				}
			});
		});
		//end update read status
		


		$('#btnInvite').click(function(e){
		    e.preventDefault();
		    var elem = $(this);
		    postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

		    return false;
		});

		function postToFeed(title, desc, url, image) 
		{
		    var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
		    function callback(response) {}
		    FB.ui(obj, callback);
		}

	});

</script>
@stop
