@extends('admin_master.layout')

@section('content')
	<form action="{{$base_url}}admin/modeltest" method="post">
		<div class="form-inline">
			<label for="category" class="control-label">Exam Category: </label>
				<select name="category" id="category">
					<option value="-1">Select Exam Category</option>
						@if($category)
							@foreach($category as $c)
							<option value="{{$c->id}}">{{$c->name}}</option>
							@endforeach
						@endif
				</select>
					
				<button class="btn btn-info" type="submit" name='search' value="1"><i class="fa fa-search"></i> Search</button>

				<a href="{{$base_url}}admin/modeltest/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> New</a>
		</div>
	</form>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Category</th>
				<th>Name</th>
				<!-- <th>Desciption</th> -->
				<th>Marks/Ques</th>
				<th>Total Ques</th>
				<th>Time(Minutes)</th>
				<th>Assigned</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@if($modeltest)
				@foreach ($modeltest as $test) 
				<?php 
				$total_ques=model_test_question_model::get_total($test->id); 
				$already_assigned=$total_ques==$test->total_ques?true:false;

				$class=$already_assigned?"class='selected-option'":'';
				?>
				
				<tr {{$class}}>
					<td>{{ref_text_model::get_text($test->category)}}</td>
					<td>{{$test->name}}</td>
					<!-- <td>{{$test->details}}</td> -->
					<td>{{$test->marks_carry}}</td>
					<td>{{$test->total_ques}}</td>
					<td>{{$test->time}}</td>
					<td>{{$total_ques}}</td>
					<td>{{$test->display?'Published':'Not Published'}}</td>
					<td style='width:200px;'>
						<a title='Manually Add' class='btn btn-default btn-mini' href="{{$base_url}}admin/add_question_manually/index/{{$test->id}}">
							<i class="fa fa-plus"></i>
						</a>
						<a data-toggle="modal" data-target="#myModal" href="{{$base_url}}admin/modeltest/assign_ques/{{$test->id}}" class="btn btn-primary btn-mini">Assign</a>
						<a data-toggle="modal" data-target="#modal_lst" href="{{$base_url}}admin/modeltest/qlist/{{$test->id}}" class="btn btn-success btn-mini">View</a>
						<a href="{{$base_url}}admin/modeltest/show/{{$test->id}}" class="btn btn-info btn-mini"><i class="fa fa-edit"></i></a>
						<a title='Assign Crash Course' class='btn btn-warning btn-mini' data-toggle='modal' data-target='#modal_roadmap' href="{{ $base_url }}admin/modeltest/roadmap_view/{{ $test->id }}/{{ $test->category }}"><i class="fa fa-plus"></i></a>
						<a href="" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
				@endforeach
			@endif
		</tbody>
	</table>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="{{$base_url}}admin/modeltest/store_ques" method="post">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Assign Question</h3>
		</div>
		<div class="modal-body">
		<p>One fine body…</p>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
		</div>
	</form>
</div>

<div id="modal_lst" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Assigned Question List</h3>
		</div>
		<div class="modal-body">
		<p>One fine body…</p>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
		</div>
</div>


<div id="modal_roadmap" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="roadmapModalLabel" aria-hidden="true">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="roadmapModalLabel">Map Crash Course</h3>
		</div>
		<div class="modal-body">
		<p>One fine body…</p>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
		</div>
</div>


@stop

@section('style')
<style>
	.table
	{
		font-size:12px;
	}
	.form-horizontal
	{
		border:1px solid #f6f6f6;
		padding-top:4px;
		padding-bottom:4px;
	}
	.selected-option
	{
		background:#F1F9F7;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myModal').on('hidden', function () {
  			$(this).removeData('modal');
		});
		$('#modal_lst').on('hidden', function () {
  			$(this).removeData('modal');
		});

		$('#modal_roadmap').on('hidden', function () {
  			$(this).removeData('modal');
		});

		$('#modal_roadmap').on('shown',function(){
			//CKEDITOR.replace('details');
		});
	});
</script>
@stop