@extends('admin_master.layout')

@section('content')

<a class="btn btn-primary" href="{{$base_url}}admin/study_hints/create">
<i class="fa fa-plus-circle"></i> Add New</a>

@if($hints)
<table class='table table-bordered'>
	<thead>
		<tr>
			<th>Title</th>
			<th>Details</th>
			<th>Display</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@foreach($hints as $hnt)
		<tr>
			<td>{{$hnt->title}}</td>
			<td>{{$hnt->details}}</td>
			<td><input disabled type="checkbox" {{$hnt->display?'checked':''}}></td>
			<td>
				<a href="{{$base_url}}admin/study_hints/edit/{{$hnt->id}}" class="btn btn-info btn-small"><i class="fa fa-edit"></i>Edit</a>
				<a onclick="return(confirm('Are you sure delete??'))" href="{{$base_url}}admin/study_hints/destroy/{{$hnt->id}}" class='btn btn-danger btn-small'><i class="fa fa-trash-o"></i>Delete</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
@endif
@stop

@section('script')
@stop