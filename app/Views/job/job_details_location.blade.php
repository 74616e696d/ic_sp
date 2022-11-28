@extends('job.front_master.master')

@section('content')
<section class="box-wrapper">
    <div class="wrapper-counts-job-box">
        <div class="container-fluid">
            <div class="container">

                <div class="row">
                    <div class="col-md-8 col-sm-8 xs-12">
                        <select style='width:40%;' name="location" id="location" class="form-control">
                           @if($location)
                           @foreach($location as $loc)
                           <option {{ $current_loc==$loc->FIELD2?'selected':'' }} value="{{ $loc->FIELD2 }}">{{ $loc->FIELD2 }}</option>
                           @endforeach
                           @endif
                        </select>
                        <br>
                        <div class="full-border-box">
                            <div class="inner-border-box">
                                <div class="col-md-6 col-sm-6 xs-12">
                                    <div class="box-layout">
                                        <ul>
                                            <li>
                                                <span>
                                                    <span class='job-count'>2'257</span> Jobs
                                                </span>
                                            </li>
                                            <li>
                                                <a class="btn btn-default cat-btn" href="#">
                                                    Get new jobs by email
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 xs-12">
                                    <div class="box-right">
                                        <ul>
                                            <li class="label">
                                                Sort order :
                                            </li>
                                            <li>
                                                Relevance
                                            </li>
                                            <li>
                                                Date
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-fix">
                            </div>
                            <div id="job-excerpt">
     							
     						</div>
                            <!-- End Item media -->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 xs-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('style')
<style>
  body{
    background: #f7f7f7;
}
.job_excerpt 
{

}
.job_excerpt h2{
	font-size: 24px !important;
}
.job_excerpt h4{
	font-size: 20px !important;
}
.job_excerpt p,.job_excerpt .date{
	color: #444 !important;
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
<script type="text/javascript">
$(document).ready(function() {
	get_job_excerpt();
	$('#location').change(function(event) {
		get_job_excerpt();
	});

});

function get_job_excerpt()
{
	var loc=$('#location').val();
	$.ajax({
		url: '{{ $base_url }}job/job_list/get_job_excerpt_list_loc',
		type: 'POST',
		data: {loc: loc}
	})
	.done(function(res) {
		$('#job-excerpt').html(res);
	});
}
</script>
@stop