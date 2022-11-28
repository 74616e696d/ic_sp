@extends('admin_master.layout')

@section('content')
<form class="form-horizontal" action="{{$base_url}}admin/cvtemp/save_details" enctype="multipart/form-data" method="post">
	<input type="hidden" name="hdn_id" value="{{ $details?$details->id:0 }}">
	<div class="control-group div_fl">
		<label for="details" class="control-label">Description </label>
		<div class="controls">
			<textarea name="details" id="details">{{ $details?$details->description:'' }}</textarea>
		</div>
	</div>

	<div class="control-group div_fl">
		<label for="video_link" class="control-label">Video Details </label>
		<div class="controls">
			<textarea name="video_link" id="video_link">{{ $details?$details->video_link:'' }}</textarea>
		</div>
	</div>

	<div class="control-group">
		<label for="event_id" class="control-label"> </label>
		<div class="controls">
			<button type="submit" class='btn btn-info'><i class="fa fa-save"></i> Save</button>
			<a href='{{ $base_url }}admin/cvtemp' class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>

@stop

@section('script')
<script src="{{ $base_url }}asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('details');
	});
</script>
@stop

