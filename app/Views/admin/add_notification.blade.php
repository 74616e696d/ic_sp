@extends('admin_master.layout')

@section('content')

<form  class="form-horizontal" action="{{$base_url}}admin/manage_notification/store" method="post">
	<div class="control-group">
		<label for="ddl_type" class="control-label">Notification type</label>
		<div class="controls">
			<select name="ddl_type" id="ddl_type">
				<option value="1">Message</option>
				<option value="2">Notification</option>
			</select>
		</div>
	</div>
		<div class="control-group">
			<label for="txt_title" class="control-label">Title</label>
			<div class="controls">
				<input type="text" name="txt_title" id="txt_title" required="required">
			</div>
		</div>

		<div class="control-group">
			<label for="txt_details" class="control-label">Details</label>
			<div class="controls">
				<textarea name="txt_details" id="txt_details" cols="30" rows="10"></textarea>
			</div>
		</div>
	
		<div class="control-group">
			<label for="ddl_assign_type" class="control-label">Assign Type</label>
			<div class="controls">
				<select name="ddl_assign_type" id="ddl_assign_type">
					<option value="1">Selected Only</option>
					<option value="5">All Users</option>
					@if($members)
					@foreach ($members as $m)
					<option value="{{$m->id}}">{{$m->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="txt_date" class="control-label">Published Date</label>
			<div class="controls">
				<input type="text" name="txt_date" id="txt_date">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label><input class="pull-left" type="checkbox" value="1" name="ck_published" id="ck_published">&nbsp;Published</label>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button class="btn btn-info" type="submit"><i class="fa fa-save"></i>&nbsp;Save</button>
				<a class='btn btn-danger' href="{{$base_url}}admin/manage_notification"><i class="fa fa-times"></i>&nbsp;Cancel</a>
			</div>
		</div>
</form>

@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#txt_date').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});
	});
</script>
@stop