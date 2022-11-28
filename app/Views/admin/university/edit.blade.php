@extends('admin_master.layout')


@section('content')
<form action="{{$base_url}}admin/university/update" method="POST" class="form-horizontal">
	<input type="hidden" name="hdn_id" value="{{$uni->id}}">
	<div class="control-group">
	<label for="txtName" class="control-label">University Name</label>
		<div class="controls">
			<input type="text" name="txtName" id="txtName" value="{{$uni->name}}">
		</div>
	</div>

	<div class='control-group'>
	<label for="txtDisplay" class="control-label">Display</label>
		<div class="controls">
			<input type="checkbox" name="txtDisplay" id="txtDisplay" value="1" {{$uni->display?'checked':''}}>
		</div>
	</div>


	<div class='control-group'>
	<label for="" class="control-label"></label>
		<div class="controls">
			<button class="btn btn-small btn-info"><i class="fa fa-save"></i> Update</button>
			<a href="{{$base_url}}admin/university" class="btn btn-small btn-danger"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')

@stop