@extends('admin_master.layout')

@section('content')
<form class="form-horizontal" action="{{$base_url}}admin/cvtemp/update" enctype="multipart/form-data" method="post">
	<input type="hidden" name="hdn_id" value="{{ $cv->id }}">
	<div class="control-group">
		<label for="fl_name" class="control-label">Name </label>
		<div class="controls">
			<input type="text" name="fl_name" id="fl_name" value="{{ $cv->name }}">
		</div>
	</div>

	<div class="control-group div_fl">
		<label for="userfile" class="control-label">File </label>
		<div class="controls">
			<input type="file" name="userfile" id="userfile">
		</div>
	</div>
	<div class="control-group external">
		<label for="event_id" class="control-label">Link </label>
		<div class="controls">
			<input type="text" name="link" id="link" value="{{ $cv->file_name }}">
		</div>
	</div>
	<div class="control-group">
		<label for="ck_external" class="control-label">Is External </label>
		<div class="controls">
			<input type="checkbox" name="ck_external" id="ck_external" value="1">
		</div>
	</div>
	<div class="control-group">
		<label for="display" class="control-label">Display </label>
		<div class="controls">
			<input type="checkbox" name="display" id="display" checked value="1">
		</div>
	</div>
	<div class="control-group">
		<label for="event_id" class="control-label"> </label>
		<div class="controls">
			<button type="submit" class='btn btn-info'><i class="fa fa-save"></i> Update</button>
			<a href="{{ $base_url }}admin/cvtemp" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('.external').hide();
	$('#ck_external').click(function(){
		if($(this).is(':checked'))
		{
			$('.external').show();
			$('.div_fl').hide();
		}
		else
		{
			$('.external').hide();
			$('.div_fl').show();
		}
	});
});
</script>
@stop