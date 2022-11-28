@extends('admin_master.layout')

@section('content')
<table class="table table-ordered table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Test Id</th>
			<th>User</th>
			<th>Reply</th>
			<th>Display</th>
			<th>
				Action
			</th>
		</tr>
	</thead>
	<tbody>
		@if($askings)
			@foreach($askings as $ask)
			<tr>
				<td>{{$ask->ask_date}}</td>
				<td>{{$ask->test_id}}</td>
				<td>{{user_model::get_user_email($ask->user_id)}}</td>
				<td>{{empty($ask->reply)?'--':$ask->reply}}</td>
				<td>
					<input disabled="disabled" type="checkbox" name="ck_display" id="ck_display" value="1" {{$ask->display?'checked':''}}>
				</td>
				<td>
					<a href="{{$base_url}}member/model_quiz_progress/show/{{$ask->test_id}}" class="btn btn-primary btn-small">
					<i class="fa fa-reply"> Reply On Question</i></a>
					<!-- <a  href="{{$base_url}}admin/asked_for_expert/reply/{{$ask->test_id}}" title="Reply" role='button' class="btn btn-info btn-small"><i class="fa fa-reply"></i> Reply</a> -->
					<a onclick="return(confirm('Are you sure to delete??'))" href="{{$base_url}}admin/asked_for_expert/delete/{{$ask->id}}" title="Delete" class="btn btn-danger btn-small">
					<i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>
@stop