@extends('admin_master.layout')

@section('content')
	<a href="{{$base_url}}admin/upcoming_model_test/create" class="btn btn-success pull-right"><i class='fa fa-plus'></i>New</a>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Category</th>
				<th>Name</th>
				<th>Exam Date</th>
				<th>Display</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@if($exams)
		@foreach($exams as $row)
		<tr>
			<td>{{ref_text_model::get_text($row->category)}}</td>
			<td>{{$row->name}}</td>
			<td>{{date_short($row->exam_date)}}</td>
			<td>{{$row->display?'Published':'Not Published'}}</td>
			<td>
				<a class="btn btn-info btn-small" href="{{$base_url}}admin/upcoming_model_test/edit/{{$row->id}}">
				<i class="fa fa-edit"></i>
				</a>
				<a onclick="return(confirm('Are you sure to delete??'))" class="btn btn-danger btn-small" href="{{$base_url}}admin/upcoming_model_test/delete/{{$row->id}}">
				<i class="fa fa-trash-o"></i>
				</a>
			</td>
		</tr>
		@endforeach
		@endif
		</tbody>
	</table>
@stop