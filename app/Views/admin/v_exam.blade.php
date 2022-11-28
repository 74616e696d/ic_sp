@extends('admin_master.layout')
@section('content')

<div class="form-inline">
	<select name="exam_cat" id="exam_cat">
		<option value="">All Exam Category</option>
		@if($exam_cat)
		@foreach($exam_cat as $row)
			<option value="{{ $row->id }}">{{ $row->name }}</option>
		@endforeach
		@endif
	</select>

	<input type="text" name="exam_name" id="exam_name" placeholder="Exam Name">

	<button id="search" class="btn btn-info"><i class="fa fa-search"></i></button>
</div>

<table id='exam_list' class="table table-striped">
	<thead>
		<tr>
			<th>Sl.</th>
			<th>Exam Category</th>
			<th>Test Type</th>
			<th>Test Name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div id="edit_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/exam/edit">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Edit  Exam</h3>
  	</div>
  	<div class="modal-body" style='max-height:500px;'>
   	 <p>One fine body…</p>
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-info pull-left"><i class='icon icon-ok-circle'></i>Save</button>
  </div>
  </form>
	</div>

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
.modal.fade.in
{
	top:3%;
}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	//display job list in datatables
	table = $('#exam_list').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"pageLength":50,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/exam/exam_list_dt",
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
		var cat=$('#exam_cat').val();
		var exam_name=$('#exam_name').val();
		var term={exam_cat:cat,exam_name:exam_name};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable


	$('#edit_dlg').on('hidden', function () {
		$(this).removeData('modal');
	});
});
</script>
@stop