@extends('admin_master.layout')

@section('content')
<form class="form-horizontal" action="{{$base_url}}admin/event_post/store" method="post">
	<div class="control-group">
		<label for="event_id" class="control-label">Event:</label>
		<div class="controls">
			<select name="event_id" id="event_id">
				<option value="">-Select-</option>
				@if($events)
					@foreach($events as $event)
					<option {{old_value('event_id')==$event->id?'selected':''}} value="{{$event->id}}">{{$event->name}}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="post_title" class="control-label">Post Title:</label>
		<div class="controls">
			<input type="text" name="post_title" id="post_title" required='required' value="{{old_value('post_title')}}" />
		</div>
	</div>

	<div class="control-group">
		<label for="details" class="control-label">Post Details</label>
		<div class="controls">
			<textarea name="details" id="details">{{old_value('post_details')}}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<label for="" class="checkbox">
				<input type="checkbox" name="ck_display" id="ck_display" {{old_value('display')?'checked':''}} value="1">
				Display
			</label>
			<br><br>

			<button class="btn btn-info" type='submit'><i class="fa fa-save"></i> Save</button>
			<a href="{{$base_url}}admin/event_post/index" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
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