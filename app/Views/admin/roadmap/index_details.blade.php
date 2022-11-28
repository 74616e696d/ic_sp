@extends('admin_master.layout')

@section('content')

<div class="form-inline">
<a href="{{ $base_url }}admin/roadmap/create_details" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New</a>

<select name="category" id="category">
	<option value="">Select Category</option>
	@if($category)
	@foreach($category as $cat)
	<option value="{{ $cat->id }}">{{ $cat->name }}</option>
	@endforeach
	@endif
</select>
<select name="course" id="course">
	<option value="">Select Crash Course Name</option>
</select>

<button type='button' id='btn_search' class="btn btn-default"><i class="fa fa-search"></i></button>
</div>

<table id='tblRoadmapDetails' width="100%" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="5%">Sl.</th>
			<th>Exam Name</th>
			<th>Topics Name</th>
			<th width="40%">Topics Details</th>
			<th>Action</th>
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
	.peaked{
		background: red;
	}
	</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});

	$('#category').change(function(){
		var category=$(this).val();

		$.ajax({
			url: '{{ $base_url }}admin/roadmap/get_roadmap',
			type: 'GET',
			data: {category:category}
		})
		.done(function(res) {
			$('#course').html(res);
		});
	});

	//display job list in datatables
	table = $('#tblRoadmapDetails').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		'pageLength':20,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/roadmap/roadmap_details_dt",
		    "type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
		{
		    "targets": [ -1 ], //last column
		    "orderable": false, //set not orderable
		},
		],
	});//end display job list in datatables

	//search datatable
	$('#btn_search').click(function() {
		var course=$('#course').val();
		var term={course:course};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
});
</script>
@stop