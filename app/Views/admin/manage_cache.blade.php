@extends('admin_master.layout')

@section('content')
<a onclick='return(confirm("Are you sure to clear database cache??"))' href="{{$base_url}}admin/manage_cache/clear_all" class="btn btn-danger">Clear Cache</a>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Full Name</th>
			<th>Controller</th>
			<th>Function Called</th>
			<th>Updated At</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@if($dirs)
		@foreach($dirs as $dr)
		<?php $dr_arr=explode('+',$dr); ?>
		<tr>
			<td>{{$dr_arr[0]}}</td>
			<td>{{$dr_arr[1]}}</td>
			<td>{{$dr}}</td>
			<td>
				<?php $info=get_file_info('./application/cachedb');
				// var_dump($info);
				$dtf=date('Y-m-d',$info['date']); ?>
				{{$dtf}}
			</td>
			<td>
				<a onclick="return(confirm('Are you sure to delete this cache ??'))" 
				href="{{$base_url}}admin/manage_cache/remove/{{$dr_arr[0]}}/{{$dr_arr[1]}}" class="btn btn-danger">
					<i class="fa fa-trash-o"></i>
				</a>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>
@stop

@section('script')

@stop

