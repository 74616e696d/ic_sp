@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/upcoming_model_test/update" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="hdn_id" value="{{$exam->id}}">
	<div class="control-group">
		<label for="ddlCategory" class="control-label">Category</label>
		<div class="controls">
			<select name="ddlCategory" id="ddlCategory">
				<option value="">Select Category</option>
				@if($category)
				@foreach($category as $cat)
				<option {{ $exam->category==$cat->id?'selected':'' }} value="{{$cat->id}}">{{$cat->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="txtTitle" class="control-label">Title</label>
		<div class="controls">
			<input type="text" name="txtTitle" id="txtTitle" value="{{$exam->name}}">
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label">Fallback Image</label>
		<div class="controls">
		<img width="150" src="{{$base_url}}asset/upload/{{$exam->fall_back_img}}" alt="No Image">
		<br>
		<input type="hidden" name='current_img' value="{{$exam->fall_back_img}}">
		<input type="hidden" name='new_img' id="new_img" value="">
		<input type="file" name="userfile" id="userfile">
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label">Exam Date</label>
		<div class="controls">
		{{date_picker('exam_date',$exam->exam_date)}}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<label class='checkbox'>
				<input {{$exam->display?'checked':''}} type="checkbox" name="display" id="display" value="1">  Display
			</label>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
			<a href="{{$base_url}}admin/upcoming_model_test" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('style')
<style type="text/css">
.dt{
	width:70px;
}
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#userfile').change(function(event) {
			$('#new_img').val($(this).val());
		});
	});
</script>
@stop