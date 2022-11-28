@extends('admin_master.layout')

@section('content')
<form action="{{$base_url}}admin/study_hints/store" method="post" class="form-horizontal">
	<div class="control-group">
		<label for="title" class="control-label">Title:</label>
		<div class="controls">
			<input type="text" name="title" id="ttile" required='required'>
		</div>
	</div>

	<div class="control-group">
		<label for="details" class="control-label">Details:</label>
		<div class="controls">
			<textarea name="details" id="details" cols="30" rows="10"></textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="display" id="display" value="1"> Display
			</label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<button type='submit' class="btn btn-info">
				<i class="fa fa-save"></i> Save
			</button>	
			<a class="btn btn-danger" href="{{$base_url}}admin/study_hints"><i class="fa fa-times-circle"></i> Cancel</a>
		</div>
	</div>
</form>
@stop


@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('details');
	});
</script>
@stop