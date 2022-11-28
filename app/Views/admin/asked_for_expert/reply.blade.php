@extends('admin_master.layout')

@section('content')
<form method="POST" action="<?php echo base_url(); ?>admin/asked_for_expert/save_reply">
<input type="hidden" name="hdn_ask_id" value="{{$ask->id}}">
<div class="form-horizontal">
	<div class="control-group">
	    <label for="" class="control-label">Asked Model Test Id</label>
	    <div class="controls">
	        <input type="text" disabled="disabled" value="{{$ask->test_id }}">
	    </div>
	</div>

	<div class="control-group">
		<label for="" class="control-label">User Email</label>
		<div class="controls">
			<input type="text" disabled="disabled" name="email" value="{{user_model::get_user_email($ask->user_id)}}">
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label">Ask Date</label>
		<div class="controls">
			<input type="text" name="" disabled="disabled" value="{{$ask->ask_date}}">
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label">Reply</label>
		<div class="controls">
			<textarea name="details" id="details">{{$ask->reply}}</textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="ck_display" {{$ask->display?'checked':''}} id="ck_display" value="1">
				Display
			</label>
		</div>
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-reply"></i> Reply</button>
			<a href="{{$base_url}}admin/asked_for_expert" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
		</div>
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