@extends('admin_master.layout')

@section('content')
<form class="form-horizontal" action="{{$base_url}}admin/current_news_category/update" method="post">
	<input type="hidden" name="hdn_id" value="{{$cat->id}}">
	<div class="control-group">
		<label for="category_name" class="control-label">Category Name:</label>
		<div class="controls">
		<input type="text" name="category_name" id="category_name" value="{{$cat->name}}"  required>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
		<label class="checkbox">
			<input type="checkbox" {{$cat->display?'checked':''}} name="display" id="display" value="1">Display
		</label>
		</div>
	</div>

	<div class="form-control">
		<div class="controls">
			<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
			<a class='btn btn-danger' href="{{$base_url}}admin/current_news_category"><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')

@stop