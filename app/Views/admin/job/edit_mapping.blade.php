@extends('admin_master.layout')

@section('content')
<div style='min-height: 500px'>
<form method="post" action="{{ $base_url }}admin/job_exam_mapping/update" class="form-horizontal">

<div class="control-group">
	<label for="ddl_company" class="control-label">Company</label>
	<div class="controls">
		<select name="ddl_company" id="ddl_company">
			<option value="">Select Company</option>
			@if($company)
			@foreach($company as $com)
			<option {{ $mapped->company_id==$com->id?'selected':'' }} value="{{ $com->id }}">{{ $com->company_name }}</option>
			@endforeach
			@endif
		</select>
	</div>
</div>

<div class="control-group">
	<label for="ddlCategory" class="control-label">Category</label>
	<div class="controls">
		<select {{ $mapped->company_id==$com->id?'selected':'' }} name="ddlCategory" id="ddlCategory">
			<option value="">Select Category</option>
			@if($exam_category)
			@foreach($exam_category as $cat)
			<option {{ $mapped->cat_id==$cat->id?'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
			@endforeach
			@endif
		</select>
	</div>
</div>

<div class="control-group">
	<label for="ddl_prev_exam" class="control-label">Previous Exam</label>
	<div class="controls">
		<select name="ddl_prev_exam[]" id="ddl_prev_exam" multiple="multiple">
		</select>
	</div>
</div>

<div class="control-group">
	<label for="ddl_model_test" class="control-label">Model Test</label>
	<div class="controls">
		<select name="ddl_model_test[]" id="ddl_model_test" multiple="multiple">
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label"></label>
	<div class="controls">
		<button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
		<a href="{{ $base_url }}admin/job_exam_mapping" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
	</div>
</div>

</form>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/css/bootstrap-multiselect.css">
<style>
	.collapse{
		overflow: auto !important;
	}
	.multiselect-container > li {
	  padding: 0 0 0 10px;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var category='{{ $mapped->cat_id }}';
	load_exam(category);

	$('#ddl_prev_exam').multiselect({
		maxHeight: 200
	});

	$('#ddl_model_test').multiselect({
		maxHeight: 200
	});

	$('#ddlCategory').change(function(e) 
	{
		var cat_id=$(this).val();
		load_exam(cat_id);
	});
});

function load_exam(cat_id)
{
	var sel_prev_exam='{{ $mapped->prev_exam }}';
	var sel_model_test='{{ $mapped->model_test }}';
	$.ajax({
		url: '{{ $base_url }}admin/job_exam_mapping/get_prev_exam',
		type: 'POST',
		data: {cat: cat_id,sel_prev_exam:sel_prev_exam}
	})
	.done(function(res) {
		$('#ddl_prev_exam').html(res);
		$('#ddl_prev_exam').multiselect('rebuild');
	});

	$.ajax({
		url: '{{ $base_url }}admin/job_exam_mapping/model_test',
		type: 'POST',
		data: {cat: cat_id,sel_model_test:sel_model_test}
	})
	.done(function(res) {
		$('#ddl_model_test').html(res);
		$('#ddl_model_test').multiselect('rebuild');
	});
}
</script>
@stop