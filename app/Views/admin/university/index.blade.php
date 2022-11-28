@extends('admin_master.layout')


@section('content')
<a href="{{$base_url}}admin/university/create" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> New</a>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>University Name</th>
			<th>Display</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@if($university)
	@foreach($university as $uni)
		<tr>
			<td>{{$uni->name}}</td>
			<td>{{$uni->display?'Display':'Not Displayed'}}</td>
			<td>
				<a href="{{$base_url}}admin/university/edit/{{$uni->id}}" class="btn btn-info btn-small">
				<i class="fa fa-edit"></i> Edit
				</a>

				<a onclick="return(confirm('Are you sure to delete ??'))" href="{{$base_url}}admin/university/delete/{{$uni->id}}" class="btn btn-danger btn-small">
				<i class="fa fa-trash-o"></i> Delete
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