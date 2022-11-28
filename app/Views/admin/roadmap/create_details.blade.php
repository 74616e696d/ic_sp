@extends('admin_master.layout')

@section('content')
<form method='post' action="{{ $base_url }}admin/roadmap/save_details">
	<div class="control-group">
		<label for="category" class="control-label">Exam ategory</label>
		<div class="controls">
			<select name="category" id="category">
				<option value="">Select Category</option>
				@if($category)
				@foreach($category as $cat)
				<option value="{{ $cat->id }}">{{ $cat->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="roadmap" class="control-label">Crash Course Name</label>
		<div class="controls">
			<select name="roadmap" id="roadmap" required>
				<option value="">-Crash Course Name-</option>
				@if($roadmap)
					@foreach($roadmap as $row)
					<option value="{{ $row->id }}">{{ $row->exam_name }}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="subject" class="control-label">Subject</label>
		<div class="controls">
			<select name="subject" id="subject">
				<option value="">-Select Subject-</option>
				@if($subjects)
					@foreach($subjects as $subj)
					<option value="{{ $subj->id }}">{{ $subj->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="topics" class="control-label">Chapter</label>
		<div class="controls">
			<select name="topics" id="topics">
				<option value="">-Select Chapter-</option>
			</select>
		</div>
	</div>


	<div class="control-group">
		<label for="details" class="control-label">Roadmap Details</label>
		<div class="controls">
			<textarea name="details" id="details"></textarea>
		</div>
	</div>

	<div class="control-group">
		<label for=""></label>
		<div class="controls">
			<button type="submit" class='btn btn-info'><i class="fa fa-save"></i> Create</button>
			<a href="{{ $base_url }}admin/roadmap/details" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace('details');

	$('#subject').change(function(){
		var id=$(this).val();
		$.ajax({
			url: '{{ $base_url }}admin/roadmap/get_chapters',
			type: 'POST',
			data: {subj: id}
		})
		.done(function(res) {
			$('#topics').html(res);
		});
		
	});


	$('#category').change(function(){
		var category=$(this).val();

		$.ajax({
			url: '{{ $base_url }}admin/roadmap/get_roadmap',
			type: 'GET',
			data: {category:category}
		})
		.done(function(res) {
			$('#roadmap').html(res);
		});
	});

});


</script>
@stop