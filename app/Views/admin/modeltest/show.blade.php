@extends('admin_master.layout')

@section('content')
<form action="{{$base_url}}admin/modeltest/update" method="post">
<div class="form-horizontal">
<!-- 	<div class="control-group">
		<label for="category" class="control-label">Exam Category</label>
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
	</div> -->
	<input type="hidden" name="hdn_id" value="{{$test->id}}">
	<div class="control-group">
		<label for="exam" class="control-label">Model Test Name</label>
		<div class="controls">
			<input type="text" name="exam" id="exam" value="{{$test->name}}" required='required'>
		</div>
	</div>
	<div class="control-group">
		<label for="details" class="control-label">Description</label>
		<div class="controls">
			<textarea name="details" id="details" cols="30" rows="6">{{$test->details}}</textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="marks_carry" class="control-label">Marks Carry(Per Question)</label>
		<div class="controls">
			<input type="text" name="marks_carry" id="marks_carry" value="{{$test->marks_carry}}" required='required'>
		</div>
	</div>
	<div class="control-group">
		<label for="total_ques" class="control-label">Total Question</label>
		<div class="controls">
			<input type="text" name="total_ques" id="total_ques" value="{{$test->total_ques}}" required='required'>
		</div>
	</div>

	<div class="control-group">
		<label for="time" class="control-label">Time Of Exam(In Minutes)</label>
		<div class="controls">
			<input type="text" name="time" id="time" required='required' value="{{$test->time}}">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" {{$test->is_paid?'checked':''}} name="ck_paid" id="ck_paid" value="1">Is Paid
			</label>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" {{$test->display?'checked':''}} name="ck_display" id="ck_display" value="1">Display
			</label>
		</div>
	</div>

	<div class="control-group">
		<label for="" class="control-label"></label>
		<div class="controls">
			<button class='btn btn-info' type="submit"><i class="fa fa-save"></i> Save</button>

			<a href="{{$base_url}}admin/modeltest" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
		</div>
	</div>


</div>
</form>
@stop

@section('script')
@stop