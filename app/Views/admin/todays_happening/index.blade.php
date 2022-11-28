@extends('admin_master.layout')

@section('content')
	<a href="{{$base_url}}admin/todays_happening/create" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New</a>
	<div class="form-inline">
		<input type="text" name="title" id="title" placeholder="Title">
		<input type="text" name="from" id="from" class="dt" placeholder="From">
		<input type="text" name="to" id="to" class="dt" placeholder="To">
		<button id="btnSearch" class="btn btn-default"><i class="fa fa-search"></i></button>
	</div>
	
	<table id="tblTodaysHappening" class="table table-bordered">
		<thead>
			<tr>
				<th>Title</th>
				<th width="40%">Details</th>
				<th>Date</th>
				<th>Displayed</th>
				<th width="10%">Action</th>
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

	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	table = $('#tblTodaysHappening').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"pageLength":20,
		"ajax": {
		    "url": "{{ $base_url }}admin/todays_happening/get_happenings_dt",
		    "type": "POST"
		},
		"columnDefs": [
		{
		    "targets": [ -1 ], //last column
		    "orderable": false, //set not orderable
		},
		],
	});//end display job list in datatables



	$('#btnSearch').click(function() {
		var title=$('#title').val();
		var from=$('#from').val();
		var to=$('#to').val();
		var term={title:title,from:from,to:to};
		table.search(JSON.stringify(term)).draw();
	});


});

</script>
@stop