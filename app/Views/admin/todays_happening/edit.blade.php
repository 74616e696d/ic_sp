@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/todays_happening/update" class="form-horizontal" enctype="multipart/form-data">
	<input type="hidden" name="hdn_id" value="{{$event->id}}">
	<div class="control-group">
		<label for="title" class="control-label">Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" required value="{{$event->title}}">
		</div>
	</div>

	<div class="control-group">
		<label for="details" class="control-label">Short Description</label>
		<div class="controls">
			<textarea name="details" id="details">{{$event->details}}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label for="details" class="control-label">Image</label>
		<div class="controls">
			<img width="150" src="{{$base_url}}asset/news/{{$event->photo}}" alt="">
			<br>
			<input type="hidden" name="hdn_new" id="hdn_new">
			<input type="hidden" name="hdn_current" value="{{$event->photo}}">
			<input type="file" name="userfile" id="userfile">
		</div>
	</div>

	<div class="control-group">
		<label for="happening_date" class="control-label">Date Happened</label>
		<div class="controls">
			{{date_picker('happening_date',$event->happening_date)}}
		</div>
	</div>

	<div class="control-group">
		<label for="display" class="control-label">Published</label>
		<div class="controls">
			<input type="checkbox" {{$event->display?'checked':''}} checked name="display" id="display" value="1">
		</div>
	</div>

	<div class="control-group">
		<label  class="control-label"></label>
		<div class="controls">
			<button class="btn btn-info"><i class="fa fa-save"></i> Update</button>
			<a href="{{$base_url}}admin/todays_happening" class="btn btn-danger">
			<i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('style')
<style>
.dt{
	width:70px;
	margin-right:10px;
}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#userfile').change(function(event) {
		$('#hdn_new').val($(this).val());
	});
});
</script>
@stop