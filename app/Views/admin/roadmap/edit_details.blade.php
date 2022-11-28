@extends('admin_master.layout')

@section('content')
<form method='post' action="{{ $base_url }}admin/roadmap/update_details">
	<input type="hidden" name="hdn_id" value="{{ $details->id }}">

	<div class="control-group">
		<label for="category" class="control-label">Exam ategory</label>
		<div class="controls">
			<select name="category" id="category">
				<option value="">Select Category</option>
				@if($category)
				@foreach($category as $cat)
				<option {{ $roadmap->category==$cat->id?'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="control-group">
		<label for="roadmap" class="control-label">Category Name</label>
		<div class="controls">
			<select name="roadmap" id="roadmap" placeholder='Roadmap Name' required>
				<option value="">-Select Roadmap/Model Test-</option>
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
					<option {{ $details->subj_id==$subj->id?'selected':'' }} value="{{ $subj->id }}">
					{{ $subj->name }}</option>
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
			<textarea name="details" id="details">{{ $details->details }}</textarea>
		</div>
	</div>

	<div class="control-group">
		<label for=""></label>
		<div class="controls">
			<button type="submit" class='btn btn-info'><i class="fa fa-save"></i> Update</button>
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

	var subj='{{ $details->subj_id }}';
	var sel='{{ $details->topics }}';
	load_chapters(subj,sel);

	$('#subject').change(function(){
		var id=$(this).val();
		load_chapters(id,0);		
	});


	var cat='{{ $roadmap->category }}';
	var sel='{{ $roadmap->id }}';
	load_roadmap(cat,sel);
	$('#category').change(function(){
		var category=$(this).val();
		load_roadmap(category,0);
	});

});

function load_roadmap(category,sel)
{
	$.ajax({
		url: '{{ $base_url }}admin/roadmap/get_roadmap',
		type: 'GET',
		data: {category:category,sel:sel}
	})
	.done(function(res) {
		$('#roadmap').html(res);
	});
}

function load_chapters(id,sel)
{
	$.ajax({
		url: '{{ $base_url }}admin/roadmap/get_chapters',
		type: 'POST',
		data: {subj: id,sel:sel}
	})
	.done(function(res) {
		$('#topics').html(res);
	});
}
</script>
@stop