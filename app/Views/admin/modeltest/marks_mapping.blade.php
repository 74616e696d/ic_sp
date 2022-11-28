@extends('admin_master.layout')

@section('content')
	<form action="{{$base_url}}" method="post" class="form-horizontal">
		<div class="control-group">
			<label for="category" class="control-label">Category</label>
			<div class="controls">
				<select name="category" id="category">
				<option value="-1">Select Exam Category</option>
					@if($category)
						@foreach($category as $c)
						<option value="{{$c->id}}">{{$c->name}}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="" class="control-label"></label>
			<div class="controls">
				<select name="" id=""></select>
			</div>
		</div>
	</form>
@stop

@section('script')
@stop