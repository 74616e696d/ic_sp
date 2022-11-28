@extends('admin_master.layout')

@section('content')
<form action="{{$base_url}}admin/job/store_category" method="post" class="form-horizontal">
	
	<div class="control-group">
		<label for="title" class="control-label">Category Name</label>
		<div class="controls">
			<input type="text" name="title" id="title" placeholder='Category Name' required>
		</div>
	</div>

	<div class="control-group">
		<label for="display" class="control-label">Display</label>
		<div class="controls">
			<input type="checkbox" name="display" id="display" value="1">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
			<a href="{{ $base_url }}admin/job/category" class="btn btn-warning"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>

</form>

@stop