@extends('admin_master.layout')

@section('content')
	<div class='form-inline'>
		<input type="text" name="post_id" id="post_id" placeholder="Post Id">
		<input type="text" name="txtTitle" id="txtTitle" placeholder='Post Title'>
		<select name="ddlStatus" id="ddlStatus">
			<option value="3">All</option>
			<option value="1">Published</option>
			<option value="2">Not Published</option>
		</select>
		<button type='button' id='btnSearch' class="btn btn-info"><i class="fa fa-search"></i> Search</button>
	</div>
	<br>
	<table id="tblPosts" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Sl</th>
				<th style='width:25%;'>Title</th>
				<th width="25%">Details</th>
				<th>Date</th>
				<th>Status</th>
				<th width="12%">Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

@section('style')
	<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/jquery.dataTables.css">
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
	.radio input[type="radio"], .checkbox input[type="checkbox"] {
	  float: left;
	  margin-left:0;
	}
	</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		//display job list in datatables
		table = $('#tblPosts').DataTable({
			"processing": true,
			"serverSide": true,
			"searching": true,
			"pageLength":20,
			// Load data for the table's content from an Ajax source
			"ajax": {
			    "url": "{{ $base_url }}admin/manage_forum/forum_posts_dt",
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
		$('#btnSearch').click(function() {
			var id=$('#post_id').val();
			var title=$('#txtTitle').val();
			var status=$('#ddlStatus').val();
			var term={id:id,title:title,status:status};
			table.search(JSON.stringify(term)).draw();
		});

		//end search datatable
		$('#tblPosts').on('click','.permit',function(){
			var current=$(this);
			var id=$(this).val();
			var stat=$(this).is(':checked')?1:0;

			$.ajax({
				url:'{{$base_url}}admin/manage_forum/publish',
				type:'post',
				data:{id:id,stat:stat}
			})
			.done(function(data){
				if(stat==1)
				{
					table.draw();
				}
				else
				{
					table.draw();
				}
			});
		});

	});
</script>
@stop