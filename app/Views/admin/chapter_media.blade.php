@extends('admin_master.layout')

@section('content')

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Chapter</th>
			<th>Media</th>
			<th>Role</th>
			<th>Display</th>
			<th>
			<a class='btn btn-mini' href="{{$base_url}}admin/chapter_media/create"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>
			</th>
		</tr>
	</thead>
	<tbody>
		@if($media)
		@foreach ($media as $m)
			<tr>
				<td>{{ref_text_model::get_text($m->chapter_id)}}</td>
				<td><!-- {{$m->media_url}} --></td>
				<td>
					{{membership_model::get_text($m->role)}}
				</td>
				<td> 
				@if($m->display){{'Published'}}@else{{'Not Published'}}@endif
				</td>
				<td>
				<a class='btn btn-mini' href="{{$base_url}}admin/chapter_media/show/{{$m->id}}"><i class="fa fa-edit"></i>&nbsp;Edit</a>

				<a onclick="return(confirm('are you sure to delete?'))" class="btn btn-danger btn-mini" href="{{$base_url}}admin/chapter_media/destroy/{{$m->id}}"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
				</td>
			</tr>
		@endforeach
		@endif
	</tbody>
</table>
@stop
@section('style')
<style>
	iframe[src*="youtube.com"], 
	iframe[src*="youtu.be"] {
	    width:auto; !important;
	    height: 150px !important;
	}
</style>
@stop
@section('script')

@stop