@extends('admin_master.layout')

@section('content')
<p>
	<a href="{{$base_url}}admin/current_news_category/create" class="btn btn-success">
	<i class="fa fa-plus"></i> New
	</a>
</p>
<table class="table table-stripped table-bordered">
	<thead>
		<tr>
			<th>Category Name</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@if($category)
	@foreach($category as $cat)
		<tr>
			<td>{{$cat->name}}</td>
			<td>{{$cat->display?'Displayed':'Not Displayed'}}</td>
			<td>
				<a href="{{$base_url}}admin/current_news_category/edit/{{$cat->id}}" class="btn btn-small btn-info"><i class="fa fa-edit"></i> Edit</a>
				<a onclick="return(confirm('Are you sure to delete ??'))" href="{{$base_url}}admin/current_news_category/delete/{{$cat->id}}" class="btn btn-small btn-danger"><i class="fa fa-times"></i> Delete</a>
			</td>
		</tr>
	@endforeach
	@endif
	</tbody>
</table>
@stop

@section('script')

@stop