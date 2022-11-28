@extends('admin_master.layout')

@section('content')

<div class="form-inline">
	<select name="category" id="category" class="form-control">
		<option value="">All Category</option>
		@if($cats)
		@foreach($cats as $cat)
		<option value="{{ $cat->id }}">{{ $cat->name }}</option>
		@endforeach
		@endif
	</select>

	<select name="subject" id="subject" class="form-control">
		<option value="">All Subject</option>
	</select>


	<input type="text" name="question" id="question" class="form-control" placeholder="Question">

	<button type="button" id="search" class="btn btn-default"><i class="fa fa-search"></i></button>

	<a href="{{$base_url}}admin/written_ques/create" title='Add New Written Question' class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i></a>
</div>
<table id='tblWrittenQues' style='width:100%;' class='table table-bordered table-striped'>
	<thead>
		<tr>
			<th>Sl.</th>
			<th>Category</th>
			<th>Subject</th>
			<th>Chapter</th>
			<th style='width:30%;'>Question</th>
			<th style='width:30%;'>Answer</th>
			<th style='width:10%;'>Action</th>
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
	.table img{
		width:100px;
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
jQuery(document).ready(function($) {

	/**
	 * get subjects by exam category
	 * @return void
	 */
	$('#category').change(function() {
		var eid=$(this).val();
		if(eid!="")
		{
			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_subjects',
				type:'POST',
				data:{eid:eid}
			})
			.done(function(data){
				$('#subject').html(data);
			});

			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_prev_exam',
				type:'POST',
				data:{eid:eid}
			})
			.done(function(data){
				$('#exam_name').html(data);
			});

		}
		else
		{
			$('#subject').html("<option value=''>Select Subject</option>");
			$('#exam_name').html("<option value=''>Select Exam Name</option>");
		}
	});


	/**
	 * display written question list in jquery datatables
	 */
	table = $('#tblWrittenQues').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"pageLength"	:25,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/written_ques/ques_list_dt",
		    "type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
		{
		    "targets": [ -1 ], //last column
		    "orderable": false, //set not orderable
		},
		],
	});//end display written question list in datatables

	//search datatable
	$('#search').click(function() {
		var cat=$('#category').val();
		var subj=$('#subject').val();
		var ques=$('#question').val();
		var term={cat:cat,subj:subj,ques:ques};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
	
});

</script>
@stop