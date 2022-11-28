@extends('admin_master.layout')

@section('content')
<a href="{{$base_url}}admin/job/create_category" class="btn btn-success pull-right">
<i class="fa fa-plus"></i>New Job Category</a>

@if($categories)
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Category Name</th>
			<th>Display</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($categories as $cat)
		<tr>
			<td>{{ $cat->title }}</td>
			<td>{{ $cat->display?'Published':'Not Published' }}</td>
			<td>
				<a href="{{ $base_url }}admin/job/edit_category/{{ $cat->id }}" class="btn btn-info btn-small">
				<i class="fa fa-edit"></i> Edit</a>
				<a onclick="return(confirm('Are you sure to delete ??'))" href="{{ $base_url }}admin/job/delete_category/{{ $cat->id }}" class="btn btn-danger btn-small">
				<i class="fa fa-trash-o"></i> Delete</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif

@stop