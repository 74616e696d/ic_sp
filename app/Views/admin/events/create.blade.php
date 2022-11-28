@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/events/store" class="form-horizontal">
	<div class="control-group">
		<label for="ename" class="control-label">Event Name:</label>
		<div class="controls">
			<input type="text" name="ename" id="ename" value="{{old_value('name')}}">
		</div>
	</div>
	
	<div class="control-group">
		<label for="details" class="control-label">Details</label>
		<div class="controls">
			<textarea name="details" id="details">{{old_value('details')}}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label for="attachment" class="control-label">Attachment</label>
		<div class="controls">
			<input type="text" name="attachment" id="attachment" value="{{old_value('attachment')}}">
		</div>
	</div>
	
	<div class="control-group">
		<label for="event_time" class="control-label">Event Date</label>
		<div class="controls">
			<input type="text" name="event_time" class='dt' id="event_time" value="{{old_value('event_time')}}">
		</div>
	</div>

	<div class="control-group">
		<label for="expire_time" class="control-label">Expire Date</label>
		<div class="controls">
			<input type="text" name="expire_time" class='dt' id="expire_time" value="{{old_value('expire_time')}}">
		</div>
	</div>

	<div class="control-group">
		<label for="featured_image" class="control-label">Featured Image</label>
		<div class="controls">
			<input type="text" name="featured_image" id="featured_image">
		</div>
	</div>	
	<div class="control-group">
		<label for="featured_image" class="control-label">Slide</label>
		<div class="controls">
			<textarea type="text" name="slide" id="slide"></textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="display" value="1" id="display" {{old_value('display')?'checked':''}}>
				Publish
			</label>
			<br><br>
			<button class="btn btn-info"><i class="fa fa-save"></i> Save</button>
			<a href="{{$base_url}}admin/events" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>

	</div>
</form>
@stop

@section('style')
<!-- <link rel="stylesheet" href="{{$base_url}}asset/css/jquery-ui-1.8.14.custom.css"> -->
<link rel="stylesheet" href="{{$base_url}}asset/vendor/datetimepicker/jquery-ui-timepicker-addon.min.css">
@stop

@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="{{$base_url}}asset/js/jquery-ui-1.10.0.custom.min.js"></script> -->
<script type="text/javascript" src="{{$base_url}}asset/vendor/datetimepicker/jquery-ui-timepicker-addon.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('details');
		$('.dt').datetimepicker({"dateFormat":"yy-mm-dd"});
	});

</script>
@stop