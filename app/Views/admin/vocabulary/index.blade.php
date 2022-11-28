@extends('admin_master.layout')

@section('content')
<a class="btn btn-primary btn-small" href="{{$base_url}}admin/vocabulary/create"><i class="fa fa-plus-circle"></i> Add New</a>
@if($vocabulary)
<table class="table table-stripped table-bordered">
	<thead>
		<tr>
			<th>Word</th>
			<th>Meaning</th>
			<th>Synonyms</th>
			<th>Antonyms</th>
			<th>Display</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		
			@foreach($vocabulary as $v)
			<tr>
				<td>{{$v->word}}</td>
				<td>{{$v->meaning}}</td>
				<td>{{$v->synonyms}}</td>
				<td>{{$v->antonyms}}</td>
				<td><input type="checkbox" class="display" {{$v->display?'checked':''}}>{{$v->display?'Published':'Not Published'}}</td>
				<td>
					<a class='btn btn-info btn-small' href="{{$base_url}}admin/vocabulary/edit/{{$v->id}}">
					<i class="fa fa-edit"></i> Edit</a>

					<a onclick="return(confirm('are you sure to delete??'))" class="btn btn-danger btn-small" href="{{$base_url}}admin/vocabulary/destroy/{{$v->id}}">
					<i class="fa fa-trash-o"></i> Delete
					</a>
				</td>
			</tr>
			@endforeach
		
	</tbody>
</table>
@endif
@stop

@section('style')
@stop

@section('script')
@stop