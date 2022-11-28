@extends('admin_master.layout')

@section('content')
<div class="form-inline">
	<input type="text" name="company" id="company" placeholder="Company Name">
	<button type="button" class='btn btn-info' id='search'><i class="fa fa-search"></i> Search</button>

	<a href="{{$base_url}}admin/company_info/create" class="btn btn-success pull-right">
	<i class="fa fa-plus"></i> New</a>
</div>
<table id='tblCompany' class="table table-bordered">
	<thead>
		<tr>
			<th>Sl.</th>
			<th>Company Name</th>
			<th>Email</th>
			<th>Web</th>
			<th>Address</th>
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
<!-- <script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/dataTables.bootstrap2.js"></script> -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	//display job list in datatables
	table = $('#tblCompany').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/company_info/company_info_dt",
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

	$('#current_news').on( 'draw.dt', function () {
		    var info = table.page.info();
		    console.dir(info);
		    var total_item=info.recordsTotal;
		    $('#current_news_info').html('Total Records:'+total_item);
	});

	//search datatable
	$('#search').click(function() {
		var company=$('#company').val();
		var term={company:company};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
});

function edit_news(id)
{
	window.location.href='{{ $base_url }}admin/current_news/edit/'+id;
}

function delete_news(id){
	var conf=confirm('Are you sure to delete ??');
	if(conf)
	{
		$.ajax({
			url: '{{ $base_url }}admin/current_news/delete',
			type: 'GET',
			data: {id: id}
		})
		.done(function() {
			table.ajax.reload(null,false);
		});
	}
}
</script>
@stop