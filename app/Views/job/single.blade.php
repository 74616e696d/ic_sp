@extends('job.front_master.master')

@section('content')
<section class="wrapper-cat-details-box">
    <div class="box-boder-layout">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="left-aside-box">
                            <div class="published-dated">
                                <b>Published :</b>
                                {{ date('d M,Y',strtotime($job->publish_date)) }}
                            </div>
                            <div class="deadline">
                                <b>Deadline :</b>
                                {{ date('d M,Y',strtotime($job->deadline)) }}
                            </div>
                            <div class="experiance">
                                <b>Experience:</b>
                                @if(!empty($job->experience))
                                {{ $job->experience }}
                                @else 
                                Not Specified
                                @endif
                            </div>
                            <div class="details">
                                <h2>Company Details</h2>
                                <div class="box-address">
                                    @if($company)
                                    <address>
                                        <div class="company-name">
                                            <b>Company Name:</b>
                                            <br/>
                                            @if(!empty($company->logo))
                                            <img src="{{ $company->logo }}" width="46" alt="{{ $company->company_name }}">
                                            @else
                                            <img src="{{ $base_url }}asset/frontend/img/blank_logo.png" width="46" alt="{{ $company->company_name }}">
                                            @endif
                                            {{ $company->company_name }}
                                        </div>
                                        @if(!empty($company->address))
                                        <b>Address:</b>
                                        <br/>
                                        {{ $company->address }} 
                                        <br/>
                                        @endif

                                        @if(!empty($company->email))
                                        <b>Email:</b>
                                        <br/>
                                        {{ $company->email }}
                                        <br/>
                                        @endif

                                        @if(!empty($company->web))
                                        <b>Web:</b>
                                        <br/>
                                        {{ $company->web }}
                                        @endif
                                    </address>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="details-box">
                            <h1>
                                {{ $job->title }}
                            </h1>
                            <h3>{{ $job->post_name }}</h3>
                            <p>
                            {{ $job->details }}
                            </p>
                            <h2>
                                Job Responsibility :
                            </h2>
                            {{ $job->job_responsibility }}
                            <h3>
                                Requirements
                            </h3>
                            {{ $job->job_requirements }}
                            <div class="job-vacancies">
                                <h3>
                                    No Of Vacancies :
                                    <span>
                                        {{ $job->vacancy_no>0?$job->vacancy_no:'N/A' }}
                                    </span>
                                </h3>
                            </div>
                            <div class="job-nature">
                                <h3>
                                    Job Nature :
                                    <span>
                                       {{ $job->job_nature }}
                                    </span>
                                </h3>
                            </div>
                            
                            <div class="job-nature">
                                <h3>
                                    Gender Requirement :
                                    <span>
                                       {{ $job->gender_requirement }}
                                    </span>
                                </h3>
                            </div>

                            <div class="box-education">
                                <h3>
                                    Education Requirements:
                                    <br/>
                                    <span>
                                        {{ $job->education }}
                                    </span>
                                </h3>
                            </div>
                            <div class="box-experiance">
                                <h3>
                                    Experience Requirements :
                                    <span>
                                        {{ $job->experience }}
                                    </span>
                                </h3>
                            </div>
                            <div class="addition-job">
                                <h3>
                                    Additional Job Requirements :
                                    <br/>
                                    <span>
                                        {{ $job->aditional_job_requirement }}
                                    </span>
                                </h3>
                            </div>
                            <div class="salary-range">
                                <h3>
                                    Salary Range : {{ $job->salary_range }}
                                </h3>
                            </div>
                            <div class="job-location">
                                <h3>
                                    Job Location :
                                    <span>
                                        {{ $job->location }}
                                    </span>
                                </h3>
                            </div>
                            <div class="apply-instruction">
                                <h3>
                                    Apply Instructions
                                    <br/>
                                    <span>
                                        {{ $job->apply_instructions }}
                                    </span>
                                </h3>
                            </div>
                            @if(!empty($job->link))
                            <div class="apply-btn">
                                <a class="btn btn-default apply" target='_blank' href="{{ $job->link }}">
                                    {{ $job->link_text }}
                                </a>
                            </div>
                            @endif
                            <div id='social'></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/jssocials/jssocials.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/jssocials/jssocials-theme-flat.css">
<style>
	.meta-box{
		width: 100%;
	}
	.meta-box h4{
		font-size: 20px;
		border-bottom: 1px solid #f6f6f6;
		padding-top: 10px;
		padding-bottom: 15px;
	}
	.meta-label{
		line-height: 22px;
		width: 25%;
		float: left;
		font-size: 16px;
		/*color:#c6c6c6;*/
	}
	.meta-value{
		line-height: 28px;
		float: right;
		font-size: 16px;
	}


	.social-bar ul li a{
		font-size: 15px;
		color: #444;
		text-decoration: none;
	}
	.social-bar ul li a i{
		margin-right: 5px;
	}

	.footer-top .container{
		padding-left:0 !important;
	}
	.job-dtls{
		padding: 20px 20px;
		border:1px solid #EEEEEE;
	}
	.job-dtls ul{
		margin-left:-15px;
	}
	.job-dtls ul li{
		padding-top: 5px;
		padding-bottom: 5px;
	}
	.job-title{color:#0177BF;}
	.company_name{
		color:#11A5B4;
		/*margin-bottom: 15px;*/
	}
	.line{
		margin-bottom: 20px;
	}
	.vacancy_line,h5{font-size: 16px;}
	.box{
		background: #F5F5F5;
		margin-bottom: 20px;
		border:1px solid #0177BF;
	}
	.box .box-title{
		color: #fff;
		margin-top: 0;
		padding: 8px 10px;
		background: #0177BF;
	}

	.box .box-body
	{
		padding: 8px;
	}
	.box .box-body i{
		margin-right: 8px;
	}
	.footer-list li a{
		text-decoration: none;
		font-size: 14px;
		line-height: 32px;
		color: #fff;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/jssocials/jssocials.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#social").jsSocials({
        showLabel: false,
        showCount: false,

        shares: [{
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.text = "(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));";
                $result.append(script);

                $("<div>").addClass("fb-share-button")
                    .attr("data-layout", "button_count")
                    .appendTo($result);

                return $result;
            }
        }, {
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.src = "https://apis.google.com/js/platform.js";
                $result.append(script);

                $("<div>").addClass("g-plus")
                    .attr({
                        "data-action": "share",
                        "data-annotation": "bubble"
                    })
                    .appendTo($result);

                return $result;
            }
        },
        {
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.text = "window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));";
                $result.append(script);

                $("<a>").addClass("twitter-share-button")
                    .text("Tweet")
                    .attr("href", "https://twitter.com/share")
                    .appendTo($result);

                return $result;
            }
        }]
    });
});

function postToFeed(title, desc, url, image){
    var imgUrl=image.length>3?image:'{{$base_url}}asset/frontend/img/'+image;
    var obj = {method: 'feed',link: url, picture:imgUrl,name: title,description: desc};
    console.log(imgUrl);
    function callback(response){}
    FB.ui(obj, callback);
}
</script>
@stop

@section('fbmeta')

<?php
$current_url=current_url();
$current_url=str_replace('index.php/', '', $current_url);
?>
<meta property="og:url" content="{{ $current_url }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $job->post_name }}" />
<meta property="og:description" content="{{ strip_tags($job->details) }}" />
@if(!empty($company->logo) && is_file_exist($company->logo))
<meta property="og:image" content="{{ $company->logo }}" />
@else
<meta property="og:image" content="{{ $base_url }}asset/frontend/img/blank_logo.png" />
@endif

@stop