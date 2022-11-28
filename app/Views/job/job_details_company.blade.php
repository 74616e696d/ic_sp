@extends('job.front_master.master')

@section('content')
<div class="container">
<div class="row">
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

	<form action="{{ $base_url }}" class="form-inline">
		<select name="company" id="company" class="form-control">
			@if($company)
			@foreach($company as $com)
			<option {{ $current_com==$com->id?'selected':'' }} value="{{ $com->id }}">{{ $com->company_name }}</option>
			@endforeach
			@endif
		</select>
		<br><br>
	</form>
	<div>
     <div id="job-excerpt">
     	
     </div>

	  <div id="pagination">
	                    
	  </div>
	</div>
	</div>
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<div class="small_spacer"></div>
		<div class="small_spacer"></div>
		<div>
			<img src="<?php echo base_url(); ?>asset/job/job_circular_category_ad.jpg" class="img-responsive"alt="#">
		</div>

		<div class="small_spacer"></div>
		<div>
			<img src="<?php echo base_url(); ?>asset/job/job_circular_category_ad.jpg" class="img-responsive"alt="#">
		</div>
	</div>
</div>
</div>
@stop

@section('style')
<style>
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
	$('#company').change(function(event) {
		get_job_excerpt();
	});

});

function get_job_excerpt()
{
	var com=$('#company').val();
	$.ajax({
		url: '{{ $base_url }}job/job_list/get_job_excerpt_list_com',
		type: 'POST',
		data: {com: com}
	})
	.done(function(res) {
		$('#job-excerpt').html(res);
	});
}
</script>
@stop