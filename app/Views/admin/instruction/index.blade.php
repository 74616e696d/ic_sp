@extends('admin_master.layout')

@section('content')
<div style='margin-bottom:10px;'>
	<a href="{{$base_url}}admin/instruction/create" class="btn btn-info">
	<i class="fa fa-plus"></i> Add New
	</a>
</div>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Exam Category</th>
			<th>Description</th>
			<th>Syllabus</th>
			<th>How To Prepare</th>
			<th>Display</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@if($instructions)
	@foreach($instructions as $ins)
	<tr>
		<td>{{ref_text_model::get_text($ins->ref_id)}}</td>
		<td>{{$ins->details}}</td>
		<td>{{$ins->syllabus}}</td>
		<td>{{$ins->hwprepare}}</td>
		<td>{{$ins->display?'Displayed':'Not Displayed'}}</td>
		<td>
			<a href="{{$base_url}}admin/instruction/edit/{{$ins->id}}" class="btn btn-small">
			<i class="fa fa-edit"></i>
			</a>
			<a onclick="return(confirm('Are you sure to delete'))" href="{{$base_url}}admin/instruction/destroy/{{$ins->id}}" class='btn btn-danger btn-small'>
			<i class="fa fa-trash-o"></i>
			</a>
		</td>
	</tr>
	@endforeach
	@endif
	</tbody>
</table>

@stop

@section('script')

@stop