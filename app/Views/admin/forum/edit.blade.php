@extends('admin_master.layout')

@section('content')
<form class='form-horizontal' action="{{$base_url}}admin/manage_forum/update" enctype="multipart/form-data" method="post">
	<input type="hidden" name="hdn_id" value="{{$post->id}}">
	<div class="control-group">
		<label for="" class="control-label">Post Date</label>
		<div class="controls">
			<input type="text" name="" id="" disabled="disabled" value="{{$post->post_date}}">
		</div>
	</div>
	<div class="control-group">
		<label for="" class="control-label">Post By</label>
		<div class="controls">
			<input type="text" name="" id="" disabled="disabled" value="{{user_model::get_user_email($post->user_id)}}">
		</div>
	</div>
	<div class="control-group">
	<label for="post_title" class="control-label">Post Title</label>
	<div class="controls">
		<input type="text" name="post_title" id="post_title" placeholder="Post Title" required="required" value="{{$post->title}}">
	</div>
	</div>

	<div class="control-group">
		<label for="post_details" class="control-label">Post Details</label>
		<div class="controls">
		<textarea name="post_details" id="post_details" cols="30" rows="10">{{$post->details}}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<labelclass="checkbox">
			<input type="checkbox" name="ck_display" id="ck_display" value="1" {{$post->display?'checked':''}}>
			</label>
		</div>
	</div>
	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			@if(file_exists('asset/upload/forum/'.$post->feature_image))
			<img width="150" class='thumbnail' src="{{ $base_url }}asset/upload/forum/{{ $post->feature_image }}" alt=""> <br>
			@endif
			<input type="hidden" name="hdn_curr_img" value="{{ $post->feature_image }}">
			<input type="file" name="userfile" id="userfile"> 
		</div>
	</div>
	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
			<a href="{{$base_url}}admin/manage_forum" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	CKEDITOR.replace('post_details');
});
</script>
@stop