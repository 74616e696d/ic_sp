@extends('admin_master.layout')

@section('content')
<form action="{{ $base_url }}admin/roadmap/update" method="post" class="form-horizontal">
	<input type="hidden" name="hdn_id" value="{{ $roadmap->id }}">
	<div class="control-group">
		<label for="category" class="control-label">Exam Category</label>
		<div class="controls">
			<select name="category" id="category">
				<option value="">Select Exam Category</option>
				@if($category)
				@foreach($category as $cat)
				<option {{ $cat->id==$roadmap->category?'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="model_test" class="control-label">Model Test</label>
		<div class="controls">
			<select name="model_test" id="model_test">
				<option value="">Select Model Test</option>
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="course_name" class="control-label">Course Name</label>
		<div class="controls">
			<input type="text" name="course_name" id="course_name" value="{{ $roadmap->exam_name }}" placeholder="Course Name">
		</div>
	</div>

	<div class="control-group">
		<label for="date" class="control-label">Course Date</label>
		<div class="controls">
			<input type="text" name="date" id="date" class="dt" value="{{ $roadmap->exam_date }}" placeholder="Course Date">
		</div>
	</div>

	<div class="control-group">
		<label for="display" class="control-label">Publish</label>
		<div class="controls">
				<input type="checkbox" name="display" id="display" {{ $roadmap->display?'checked':'' }} value="1">
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
		</div>
	</div>
</form>
@stop

@section('script')
<script type="text/javascript">
$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
$(document).ready(function() {

	var cat=$('#category').val();
	var sel='{{ $roadmap->test_id }}';
	load_model_test(cat,sel);

	//get model test of a category
	$('#category').change(function(){
		var category=$(this).val();
		load_model_test(category,'');
	
	});//end get model test of a category
});


var load_model_test=function(category,sel){
	$.ajax({
		url: '{{ $base_url }}admin/roadmap/get_course',
		type: 'GET',
		data: {category: category,sel:sel}
	})
	.done(function(res) {
		$('#model_test').html(res);
	});
};
</script>

@stop