@extends('admin_master.layout')

@section('content')
<table class="table table-bordered table-stripped">
	<thead>
		<tr>
			<th>User Email</th>
			<th>Post</th>
			<th style='width:300px;'>Comment</th>
			<th>Date</th>
			<th style='width:70px;'>Action</th>
		</tr>
	</thead>
	<tbody>
	@if($comments)
		@foreach($comments as $com)
		<tr>
			<td>{{user_model::get_user_email($com->user_id)}}</td>
			<td>{{$com->post_title}}</td>
			<td>{{$com->comment}}</td>
			<td>{{date_long($com->comment_date)}}</td>
			<td>
				<a title='Modify' href="{{$base_url}}admin/post_comment/edit/{{$com->id}}" class="btn btn-info btn-small"><i class="fa fa-edit"></i></a>

				<a onclick="return(confirm('Are you sure to delete'))" href="{{$base_url}}admin/post_comment/delete/{{$com->id}}" class="btn btn-danger btn-small"><i class="fa fa-trash-o"></i> </a>
			</td>
		</tr>
		@endforeach
	@endif
		
	</tbody>
</table>

@stop