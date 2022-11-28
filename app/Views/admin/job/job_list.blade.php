@extends('admin_master.layout')
@section('content')
<a class='btn btn-info' href="{{ $base_url }}admin/job">Post New Job</a>
<br><br>
<div class="form-inline">
	<select name="category" style='width:130px;' id="category">
		<option value="">All Job Category</option>
		@if($category)
		@foreach($category as $cat)
		<option value="{{ $cat->id }}">{{ $cat->title }}</option>
		@endforeach
		@endif
	</select>
	<input type="text" name="post_date" style='width:140px;' class='dt' id="post_date" placeholder="Post Date">

	<input type="text" name="deadline" style='width:140px;' class='dt' id="deadline" placeholder="Deadline">
	<input type="text" name="title" style='width:140px;' id="title" placeholder="Job Title">
	<select style='width:100px;' name="published" id="published">
		<option value="">All</option>
		<option value="1">Published</option>
		<option value="0">Not Published</option>
	</select>
	<button type="button" id='search' class="btn btn-info"><i class="fa fa-search"></i></button>
</div>
<table width="100%" id='job_list' class="table table-striped table-bordered">
    <thead>
        <th width="30%">Title</th>
        <th width="20%">Post Name</th>
        <th width="20%">Post Date</th>
        <th>Deadline</th>
        <th>Is Published</th>
        <th width='15%'>Action</th>
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
<!-- <script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/dataTables.bootstrap.min.js"></script> -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	//display job list in datatables
	table = $('#job_list').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/job/job_list_dt",
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
	$('#search').click(function() {
		var cat=$('#category').val();
		var post_date=$('#post_date').val();
		var deadline=$('#deadline').val();
		var status=$('#published').val();
		var title=$('#title').val();
		var term={cat:cat,pdate:post_date,deadline:deadline,status:status,title:title};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
});

function edit_job(id)
{
	window.location.href='{{ $base_url }}admin/job/edit/'+id;
}

function delete_job(id){
	var conf=confirm('Are you sure to delete ??');
	if(conf)
	{
		$.ajax({
			url: '{{ $base_url }}admin/job/remove',
			type: 'GET',
			data: {id: id}
		})
		.done(function() {
			table.draw();
		});
	}
}
</script>
@stop