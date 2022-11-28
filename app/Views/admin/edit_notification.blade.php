@extends('admin_master.layout')

@section('content')

<form  class="form-horizontal" action="{{$base_url}}admin/manage_notification/update" method="post">
<input type="hidden" name="hdn_id" value="{{$message->id}}">
	<div class="control-group">
		<label for="ddl_type" class="control-label">Notification type</label>
		<div class="controls">
			<select name="ddl_type" id="ddl_type">
				<option @if($message->type=='1'){{'selected'}}@endif value="1">Message</option>
				<option @if($message->type=='2'){{'selected'}}@endif value="2">Notification</option>
			</select>
		</div>
	</div>
		<div class="control-group">
			<label for="txt_title" class="control-label">Title</label>
			<div class="controls">
				<input type="text" name="txt_title" id="txt_title" required="required" value="{{$message->title}}">
			</div>
		</div>

		<div class="control-group">
			<label for="txt_details" class="control-label">Details</label>
			<div class="controls">
				<textarea name="txt_details" id="txt_details" cols="30" rows="10">{{$message->details}}</textarea>
			</div>
		</div>
	
		<div class="control-group">
			<label for="ddl_assign_type" class="control-label">Assign Type</label>
			<div class="controls">
				<select name="ddl_assign_type" id="ddl_assign_type">
					<option @if($message->assign_to=='1'){{'selected'}}@endif value="1">Selected Only</option>
					<option @if($message->assign_to=='5'){{'selected'}}@endif value="5">All Users</option>
					@if($members)
					@foreach ($members as $m)
					<option @if($m->id==$message->assign_to){{'selected'}}@endif value="{{$m->id}}">{{$m->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="txt_date" class="control-label">Published Date</label>
			<div class="controls">
				<?php $dt=date_create($message->publish_date);$dtf=date_format($dt,'Y-m-d'); ?>
				<input type="text" name="txt_date" id="txt_date" value="{{$dtf}}">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label><input @if($message->published){{'checked'}}@endif class="pull-left" type="checkbox" value="1" name="ck_published" id="ck_published">&nbsp;Published</label>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button class="btn btn-info" type="submit"><i class="fa fa-save"></i>&nbsp;Update</button>
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