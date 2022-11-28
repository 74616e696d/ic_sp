@extends('admin_master.layout')


@section('content')
<a href="{{ $base_url }}admin/cvtemp/create" class="btn btn-success btn-small pull-right"><i class="fa fa-plus"></i> New</a>
&nbsp;&nbsp;&nbsp;
<a href="{{ $base_url }}admin/cvtemp/details" class="btn btn-info btn-small pull-right">&nbsp;&nbsp;&nbsp;
<i class="fa fa-plus"></i> Add Description</a>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>CV</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@if($cvs)
		@foreach($cvs as $cv)
		<tr>
			<td>{{ $cv->name }}</td>
			<td>
				<a class="btn btn-primary btn-small" data-toggle="modal" data-target='#modal-id' href='{{ $base_url }}admin/cvtemp/cover_letter/{{ $cv->id }}'>Add Cover Letter</a>
				<a href="{{ $base_url }}admin/cvtemp/edit/{{ $cv->id }}" class="btn btn-small btn-info">
				<i class="fa fa-edit"></i></a>
				<a onclick='return(confirm("Are you sure to delete ??"))' href="{{ $base_url }}admin/cvtemp/delete/{{ $cv->id }}/{{ $cv->file_name }}/{{ $cv->is_external }}" class="btn btn-small btn-danger">
				<i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>


<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Cover Letter</h4>
			</div>
			<div class="modal-body">
				
			</div>
		</div>
	</div>
</div>
@stop