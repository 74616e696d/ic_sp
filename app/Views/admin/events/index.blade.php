@extends('admin_master/layout')


@section('content')

<a href="{{$base_url}}admin/events/create" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add New</a>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Event Name</th>
			<th style='width:250px;'>Details</th>
			<th>Attachment</th>
			<th>Event Date</th>
			<th>Expire Date</th>
			<th>Total Checked In</th>
			<th>Display</th>
			<th style='width:70px;'>Action</th>
		</tr>
	</thead>
	<tbody>
		@if($events)
		@foreach($events as $evnt)
		<tr>
			<td>{{$evnt->name}}</td>
			<td>{{word_limiter($evnt->details,30)}}</td>
			<td>{{$evnt->attachment}}</td>
			<td>{{date_long($evnt->event_time)}}</td>
			<td>{{date_long($evnt->expitre_time)}}</td>
			<th><span class="badge badge-info">{{check_in_model::checked_count($evnt->id)}}</span></th>
			<td>{{$evnt->display?'Displayed':'Not Displayed'}}</td>
			<td>
				<a href="{{$base_url}}admin/events/edit/{{$evnt->id}}" class="btn btn-info btn-mini"><i class="fa fa-edit"></i></a>
				<a onclick="return(confirm('Are you sure to delete??'))" href="{{$base_url}}admin/events/delete/{{$evnt->id}}" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>
@stop


@section('script')

@stop