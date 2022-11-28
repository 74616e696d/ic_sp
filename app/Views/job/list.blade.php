@extends('job.front_master.master')

@section('content')
<!-- START CONTENT -->
<section class="job-header-box">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box-top-header">
                        <p>
                            LOOKING FOR A GOOD
                            <strong>
                                JOB?
                                <br/>
                            </strong>
                            <cite>
                                FIND IT ON
                                <cite>
                                    <b>
                                        iconpreparation.com
                                    </b>
                                </cite>
                            </cite>
                        </p>
                    </div>
                    <div class="job-search">
                        <form class="form-horizontal" target="_blank" action="{{ $base_url }}job/job_list/search" id="job-search" method="post">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-5">
                                <div class="form-group">
                                    <input class="form-control" name="term" placeholder="Job Title, Company, Category, Position" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Job Title, Company, Category, Position'"/>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <button class="btn btn-success" data-toggle="#jobInfo" type="submit">
                                    FIND JOBS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="whole-wrapper-layout">
    <section class="job-category-box">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h2>
                            JOBS CATEGORY
                        </h2>
                        <div class="box-categories-layout">
                            <ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#search_by_category">
                                        Jobs By Category
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#search-by-location">
                                        Jobs By Location
                                    </a>
                                </li>
                             <!--    <li>
                                    <a data-toggle="tab" href="#search-by-company">
                                        Jobs By Company
                                    </a>
                                </li> -->
                                <li>
                                    <a data-toggle="tab" href="#deadline-tomorrow">
                                        Deadline Tomorrow
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="my-tab-content">
                                <div class="tab-pane active" id="search_by_category">
                                	@include('job.partial.job_by_category')
                                </div>
                                <!-- red end-->
                                <div class="tab-pane" id="search-by-location">
                                  @include('job.partial.job_by_location')
                                </div>
                              <!--   <div class="tab-pane" id="search-by-company">
                                </div> -->
                                <div class="tab-pane" id="deadline-tomorrow">
                                   @include('job.partial.job_by_deadline')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Category -->
    <!-- Useful Tools for Your Job Search start -->
    <div class="title-layout">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h2>
                            Useful Tools for Your Job Search
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="job-box">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <div class="cv-apply">
                            <div class="pdf-box">
                                <img src="/asset/job/theme/images/cv-icon.png"/>
                            </div>
                            <h2>
                                Your CV applies for you.
                            </h2>
                            <h3>
                                Create a CV and let yourself be found.
                            </h3>
                            <a class="btn btn-default learn-more" href="/job/job_list/cv">
                                Learn More...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="career-box">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="guide-box-first">
                            <div class="media">
                                <a class="pull-right" href="#">
                                    <img class="media-object" src="/asset/job/theme/images/job-icon-box.png">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        Career Guide
                                    </h4>
                                    <p>
                                        The most recent job offers per email  every day
                                    </p>
                                    <a class="btn btn-default learn-go" href="/job/job_list/cv">
                                        Go..
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="guide-box-sec">
                            <div class="media">
                                <a class="pull-right" href="#">
                                    <img class="media-object" src="/asset/job/theme/images/job-pencil.png">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        Resumee Writting Tips
                                    </h4>
                                    <p>
                                        The most recent job offers per email every day
                                    </p>
                                    <a class="btn btn-default learn-go" href="/job/job_list/cv">
                                        More...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End career-box -->

    <!-- START FEATURED JOBS -->
    <section class="hot-job-box">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h2 class="header-title">
                            Discover Hot Jobs
                        </h2>
                    </div>
                    @include('job.partial.featured_job')
                </div>
            </div>
        </div>
    </section>
    <!-- END FEARURED JOBS -->


	<!-- START STUDENTS JOBS -->
	<section class="hot-job-box">
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12 col-sm-12 col-xs-12">
	                    <h2 class="header-title">
	                        Student Jobs
	                    </h2>
	                </div>
	                @include('job.partial.student_jobs')
	            </div>
	        </div>
	    </div>
	</section>
	<!-- END STUDENTS JOBS -->

</div>
<!-- END CONTENT -->
@stop

@section('style')
<style>
  body{
    background: #f7f7f7;
}
	.whole-wrapper-layout .job-category-box .ul-layout li a {
	  color: #4e575d;
	  font-size: 14px;
	  line-height: 30px;
	  font-weight: 400;
	  padding-left: 15px;
	}
    .whole-wrapper-layout .career-box .guide-box-first .media-body p {
  color: #393941;
  font-size: 14px;
  font-weight: 400;
  line-height: 25px;
}
.whole-wrapper-layout .career-box .guide-box-sec .media-body p {
  color: #393941;
  font-size: 14px;
  line-height: 25px;
  font-weight: 400;
}
.whole-wrapper-layout .hot-job-box .hot-box p {
  color: #666666;
  font-size: 13px;
  font-weight: 400;
  text-align: center;
}
.thumbnail {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  display: inline !important;
  line-height: 1.42857;
  margin-bottom: 20px;
  padding: 4px;
  transition: all 0.2s ease-in-out 0s;
}
.hot-box{
    border:1px solid #e7e7e7 !important;
}
</style>
@stop
