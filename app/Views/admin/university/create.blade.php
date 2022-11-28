@extends('admin_master.layout')


@section('content')

	<form action="{{$base_url}}admin/university/store" method="POST" class="form-horizontal">
		<div class="control-group">
		<label for="txtName" class="control-label">University Name</label>
			<div class="controls">
				<input type="text" name="txtName" id="txtName">
			</div>
		</div>

		<div class='control-group'>
		<label for="txtDisplay" class="control-label">Display</label>
			<div class="controls">
				<input type="checkbox" name="txtDisplay" id="txtDisplay" value="1">
			</div>
		</div>


		<div class='control-group'>
		<label for="" class="control-label"></label>
			<div class="controls">
				<button class="btn btn-small btn-info"><i class="fa fa-save"></i> Save</button>
				<a href="{{$base_url}}admin/university" class="btn btn-small btn-danger"><i class="fa fa-times"></i> Cancel</a>
			</div>
		</div>
	</form>
@stop

@section('script')

@stop