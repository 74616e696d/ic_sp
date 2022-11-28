@extends('admin_master.layout')

@section('content')

	<a href="{{ $base_url }}admin/job_exam_mapping/create" class="btn btn-success"><i class="fa fa-plus"></i> New</a>
<br><br>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Company Name</th>
			<th>Previous Exams</th>
			<th>Model Tests</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@if($mapping)
	@foreach($mapping as $map)
		<tr>
			<td>{{$map['company_name']}}</td>
			<td width="35%">{{ $map['prev_exam_name']}}</td>
			<td width="35%">{{ $map['model_test_name'] }}</td>
			<td width="10%">
				<a href="{{ $base_url }}admin/job_exam_mapping/edit/{{ $map['company_id'] }}/{{ $map['cat_id'] }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
				<a onclick="return(confirm('Aare you sure delete ??'))" href="{{ $base_url }}admin/job_exam_mapping/{{ $map['company_id'] }}" class="btn btn-default"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
	@endforeach
	@endif
	</tbody>
</table>
@stop