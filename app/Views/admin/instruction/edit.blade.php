@extends('admin_master.layout')


@section('content')
<form class="form-horizontal" method="post" action="{{$base_url}}admin/instruction/update">
	<input type="hidden" name="hdn_id" value="{{$ins->id}}">
	<div class="control-group">
		<label for="reftexts" class="control-label">Exam Category</label>
		<div class="controls">
		<select name="reftexts" id="reftexts">
		<option value="">Select Exam Category</option>
		@if($exams)
			@foreach($exams as $exam)
			<option {{ $ins->ref_id==$exam->id?'selected':'' }} value="{{$exam->id}}">{{$exam->name}}</option>
			@endforeach
		@endif
		</select>
		</div>
	</div>

	<div class="control-group">
		<label for="details" class="control-label">Description</label>
		<div class="controls">
			<textarea name="details" id="details">{{$ins->details}}</textarea>
		</div>
	</div>
	

	<div class="control-group">
		<label for="syllabus" class="control-label">Syllabus</label>
		<div class="controls">
			<textarea name="syllabus" id="syllabus">{{$ins->syllabus}}</textarea>
		</div>
	</div>

	<div class="control-group">
		<label for="hwprepare" class="control-label">How To Prepare</label>
		<div class="controls">
			<textarea name="hwprepare" id="hwprepare">{{$ins->hwprepare}}</textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<div class="checkbox">
			<label>
			<input type="checkbox" name="ck_display" id="ck_display" {{$ins->display?'checked':''}} value="1">
			Display
			</label>
			</div>
		</div>
	</div>
	
	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<button class="btn btn-info"><i class="fa fa-save"></i> Update</button>
			<a href="{{$base_url}}admin/instruction/index" class="btn btn-danger"><i class="fa fa-time"></i> Cancel</a>
		</div>
	</div>


</form>
@stop


@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	CKEDITOR.replace('details');
	CKEDITOR.replace('syllabus');
	CKEDITOR.replace('hwprepare');
</script>
@stop