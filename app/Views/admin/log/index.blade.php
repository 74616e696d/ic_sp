@extends('admin_master.layout')

@section('content')
<a class='btn btn-primary btn-small' href="{{$base_url}}admin/activity_log/create"><i class="fa fa-plus-circle"></i> Create</a>
@if($logs)
<table class="table table-bordered">
<thead>
	<tr>
		<th>Title</th>
		<th>Details</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	@foreach($logs as $log)
		<tr>
			<td>{{$log->title}}</td>
			<td>{{$log->details}}</td>
			<td>
				<a href="{{$base_url}}admin/activity_log/edit/{{$log->id}}" class="btn btn-info btn-small">
				<i class="fa fa-edit"></i>Edit</a>

				<a onclick='return(confirm("Do you really want to delete??"))' href="{{$base_url}}admin/activity_log/destroy/{{$log->id}}" class="btn btn-danger btn-small"><i class="fa fa-trash-o"></i> Delete</a>
			</td>
		</tr>
	@endforeach
</tbody>
</table>
@endif

@stop


@section('script')

@stop