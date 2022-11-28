@extends('admin_master.layout')

@section('content')
<div class="form-inline">
	<input type="text" name="start" id="start" class='dt' placeholder="From">
	<input type="text" name="to" id="to" class='dt' placeholder="To">
	<button type='button' id="btn_search" class="btn btn-default" style='margin-bottom: 0'><i class="fa fa-search"></i></button>
</div>
<div id="divTotal"></div>

<table id="tblPr" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Sl.</th>
			<th>Date</th>
			<th>Student</th>
			<th>Membership</th>
			<th>Duration</th>
			<th>Source</th>
			<th style='text-align: right'>Amount (Tk.)</th>
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
	table tbody tr td:last-child{
		text-align: right;
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
	//display job list in datatables
	table = $('#tblPr').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		'pageLength':20,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/pr/history_dt",
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

	table.on( 'xhr', function () {
	    var json = table.ajax.json();
	    $('#divTotal').html('<h3>Total Receive Amount (Tk.): '+json.total_amount+'</h3>');
	} );

	//search datatable
	$('#btn_search').click(function() {
		var start=$('#start').val();
		var to=$('#to').val();
		var term={start:start,to:to};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
});
</script>
@stop