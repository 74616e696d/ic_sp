@extends('admin_master.layout')

@section('content')
 <form class="form-horizontal" action="{{$base_url}}admin/activity_log/store" method="post">
 	<div class="control-group">
 		<label for="title" class="control-label">Title</label>
 		<div class="controls">
 			<input type="text" name="title" id="title" required='required'>
 		</div>
 	</div>
 	<div class="control-group">
 		<label for="details" class="control-label">Details</label>
 		<div class="controls">
 			<textarea name="details" id="details" cols="30" rows="10"></textarea>
 		</div>
 	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				Display <input type="checkbox" name="display" id="display" value="1">
			</label>
		</div>
	</div>
 	<div class="control-group">
 		<label for="" class="control-label"></label>
 		<div class="controls">
 			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
 			<a href="{{$base_url}}admin/activity_log" class="btn btn-danger"><i class="fa fa-times">Cancel</i></a>
 		</div>
 	</div>
 </form>
@stop


@section('script')

@stop