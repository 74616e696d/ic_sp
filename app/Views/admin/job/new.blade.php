@extends('admin_master.layout')

@section('content')

<div class="row">
	<form action="{{ $base_url }}admin/job/create" method="post">
	<div class="span7 job-left">
		<label for="ddl_company" class="control-label">Company</label>
		<select name="ddl_company" id="ddl_company">
			<option value="">Select Company</option>
			@if($company)
			@foreach($company as $com)
			<option value="{{ $com->id }}">{{ $com->company_name }}</option>
			@endforeach
			@endif
		</select>

			<label for="job_category" class="control-label">Job Category</label>
			<select name="job_category" id="job_category">
				<option value="">-Select Job Category-</option>
				@if($categories)
					@foreach($categories as $cat)
					<option value="{{ $cat->id }}">{{ $cat->title }}</option>
					@endforeach
				@endif
			</select>

			<label for="txt_title" class="control-label">Job Title</label>
			<input type="text" name="txt_title" id="txt_title" required='required'>

			<label for="post_name" class="control-label">Post Name</label>
			<input type="text" name="post_name" id="post_name">
			
			<label for="short_desc" class="control-label">Short Description</label>
			<textarea name="short_desc" id="short_desc" style='width:100%'></textarea>

			<label for="txt_job_details" class="control-label">Job Responsibility</label>
			<textarea name="txt_job_details" id="txt_job_details"></textarea> 

			<label for="txt_job_requirement" class="control-label">Job Requirements</label>
			<textarea name="txt_job_requirement" id="txt_job_requirement"></textarea> 
				
			<label for="txt_apply_instructions" class="control-label">Apply Instructions</label>
			<textarea name="txt_apply_instructions" id="txt_apply_instructions"></textarea> 

			<label for="txt_education" class="control-label">Education</label>
			<textarea name="txt_education" id="txt_education" style='width:100%'></textarea> 

			<label for="txt_exp" class="control-label">Experience</label>
			<input type='text' name="txt_exp" id="txt_exp">

			<label for="txt_exp_details" class="control-label">Experience Details</label>
			<textarea name="txt_exp_details" id="txt_exp_details" style='width:100%'></textarea>

			<label for="txt_additional_req" class="control-label">Aadditional Job Requirement</label>
			<textarea name="txt_additional_req" id="txt_additional_req"></textarea>
			
	</div>
	<div class="span4 job-right">
		<label for="txt_vacancy" class='control-label'>Number Of Vacancy</label>
		<input type="number" min="0" max="1000" value="0" name="txt_vacancy" id="txt_vacancy">

		<label for="txt_salary_range" class='control-label'>Salary Range</label>
		<input type="text" name="txt_salary_range" id="txt_salary_range">

		<label for="txt_pub_date" class='control-label'>Publish Date</label>
		<input type="text" name="txt_pub_date" id="txt_pub_date" class="dt">

		<label for="ddl_job_nature" class="control-label">Job Nature</label>
		<select name="ddl_job_nature" id="ddl_job_nature">
			<option value="Full Time">Full Time</option>
			<option value="Part Time">Part Time</option>
			<option value="Student">Student</option>
			<option value="Contractual">Contractual</option>
		</select>
		
		<label for="ddl_gender" class="control-label">Gender Requirement</label>
		<select name="ddl_gender" id="ddl_gender">
			<option value="Any">Any</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select>

		<label for="link_text" class="control-label">Company Logo</label>
		<img width="50" id='logo_img' src="" alt="No Logo"> <br>
		<input type="text" name="logo" id="logo"> 	
		<a href="{{$base_url}}admin/news/pick_files" data-target="#myModal" role="button" class="btn" data-toggle="modal"><i class="fa fa-picture-o"></i></a>

		<label for="deadline" class='control-label'>Deadline</label>
		<input type="text" name="deadline" id="deadline" class="dt">

		<label for="location" class="control-label">Job Location</label>
		<select name="location" id="location">
			@if($district)
			@foreach($district as $dis)
			<option value="{{ $dis->FIELD2 }}">{{ $dis->FIELD2 }}</option>
			@endforeach
			@endif
		</select>

		<label for="tags" class="control-label">Tags</label>
		<textarea name="tags" id="tags"></textarea>

		<label for="link" class="control-label">Link</label>
		<input type="text" name="link" id="link">

		<label for="link_text" class="control-label">Link Text</label>
		<input type="text" name="link_text" id="link_text">
		<br>
		<label class="checkbox">
			<input type="checkbox" name="ck_display" id="ck_display" value="1">Display
		</label>
		<br>
		<label class="checkbox">
			<input type="checkbox" name="is_featured" id="ck_display" value="1">Is Featured
		</label>
	</div>
	<div class="clearfix"></div>
	<div class="span12 form-action">
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-default">Create</button>
				<a href="{{$base_url}}admin/job/job_list" class="btn btn-danger">
				<i class="fa fa-times-circle"></i> Cancel</a>
			</div>
		</div>
	</div>
	</form>
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Select Company Logo</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/vendor/dropzone/dropzone.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/select2/select2.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/select2/select2-bootstrap.css">
<style>
	.select2-container
	{
		width: 220px;
	}
	.job-left{
		margin-left: 50px !important;
		padding: 10px;
		min-height: 600px;
		/*border-right:1px solid #ddd;*/
	}
	.job-right{
		padding: 10px;
		padding-left: 20px;
		background: #F5F5F5;
	}
	.job-right .controls{
		margin-left:20px;
	}
	.form-action{
		margin-top: 20px;
		padding-left: 30px;
	}
	.checkbox{
		display: inline-block;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/vendor/dropzone/dropzone.js"></script>
<script type="text/javascript" src="{{ $base_url }}asset/vendor/select2/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('txt_job_details');
		CKEDITOR.replace('txt_additional_req');
		CKEDITOR.replace('txt_job_requirement');
		CKEDITOR.replace('txt_apply_instructions');
		// CKEDITOR.config.width="450";
		$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});


		$('#myModal').on('shown', function () {
			$(this).removeData('.modal');
		});
		$(document).on("click", "#myModal a.thumbnail", function (e) {
			e.preventDefault();
			var logo=$(this).data('img');
			var logo_path='{{$base_url}}asset/job/'+logo;
			$('#logo_img').attr('src',logo_path);
			$('#logo').val(logo);
			$('#myModal').modal('hide');
		});

		//select 2
		$('#location').select2();
		//end select 2

	});

	function reload_files()
	{
		$.ajax({
			url: '{{$base_url}}admin/news/reload_files',
			type: 'GET'
		})
		.done(function(res) {
			$('#myModal .file-box').html(res);
		});
	}
</script>
@stop