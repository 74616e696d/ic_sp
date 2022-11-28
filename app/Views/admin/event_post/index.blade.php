@extends('admin_master.layout')

@section('content')
<div class="form-inline">
	<input type="text" name="title" id="title" placeholder='Post Title'>
	<select name="category" id="category">
		<option value="">All Event</option>
		@if($events)
		@foreach($events as $cat)
		<option value="{{ $cat->id }}">{{ $cat->name }}</option>
		@endforeach
		@endif
	</select>
	
	<button type="button" class='btn btn-info' id='search'><i class="fa fa-search"></i> Search</button>

	<a href="{{$base_url}}admin/event_post/create" class="btn btn-primary btn-small pull-right">
	<i class="fa fa-plus-circle"></i>
	New Post
	</a>
</div>

	<br><br>
	<table id='tblEventPost' class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style='width:200px;'>Event</th>
				<th style='width:200px;'>Post Title</th>
				<th>Post Details</th>
				<th>Display</th>
				<th style='width:75px;'>Aaction</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop
@section('style')
	<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/jquery.dataTables.css">
	<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/dataTables.bootstrap.min.css">
	<style>
	img
	{
	with:180px;
	}
	.dataTables_filter{display: none;}
	.dataTables_length{display: none;}
	table.dataTable thead .sorting, 
	table.dataTable thead .sorting_asc, 
	table.dataTable thead .sorting_desc {
	    background : none;
	}

	table.dataTable thead .sorting::after, table.dataTable thead .sorting_asc::after, 
	table.dataTable thead .sorting_desc::after, 
	table.dataTable thead .sorting_asc_disabled::after,
	table.dataTable thead .sorting_desc_disabled::after {
	  bottom: 8px;
	  display: none;
	  font-family: "Glyphicons Halflings";
	  opacity: 0.5;
	  position: absolute;
	}
	</style>
@stop
@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	table = $('#tblEventPost').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"pageLength":20,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/event_post/event_post_list_dt",
		    "type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
		{
		    "targets": [ -1 ], //last column
		    "orderable": false, //set not orderable
		},
		],
	});

	//search datatable
	$('#search').click(function() {
		var cat=$('#category').val();
		var title=$('#title').val();
		var term={cat:cat,title:title};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable

});
</script>
<script src="text/javascript">
	$(document).ready(function() {
		//display job list in datatables
		// table = $('#tblEventPost').DataTable({
		// 	"processing": true,
		// 	"serverSide": true,
		// 	"searching": true,
		// 	// Load data for the table's content from an Ajax source
		// 	"ajax": {
		// 	    "url": "{{ $base_url }}admin/event_post/event_post_list_dt",
		// 	    "type": "POST"
		// 	},
		// 	//Set column definition initialisation properties.
		// 	"columnDefs": [
		// 	{
		// 	    "targets": [ -1 ], //last column
		// 	    "orderable": false, //set not orderable
		// 	},
		// 	],
		// });
		//end display job list in datatables

		// $('#current_news').on( 'draw.dt', function () {
		// 	    var info = table.page.info();
		// 	    console.dir(info);
		// 	    var total_item=info.recordsTotal;
		// 	    $('#current_news_info').html('Total Records:'+total_item);
		// });

		//search datatable
		// $('#search').click(function() {
		// 	var cat=$('#category').val();
		// 	var post_date=$('#post_date').val();
		// 	var title=$('#title').val();
		// 	var status=$('#status').val();
		// 	var term={cat:cat,pdate:post_date,title:title,status:status};
		// 	table.search(JSON.stringify(term)).draw();
		// });
		//end search datatable
	});
</script>
@stop