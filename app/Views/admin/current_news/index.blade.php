@extends('admin_master.layout')


@section('content')
<p>
<a href="{{$base_url}}admin/current_news/create" class="btn btn-success">
<i class="fa fa-plus"></i> New</a>

<a href="{{ $base_url }}admin/meta_tag" class="btn btn-success"><i class="fa fa-plus"></i> Manage Meta Tags</a>
</p>

<div class="form-inline">
	<select name="category" id="category">
		<option value="">All Category</option>
		@if($category)
		@foreach($category as $cat)
		<option value="{{ $cat->id }}">{{ $cat->name }}</option>
		@endforeach
		@endif
	</select>
	<input type="text" name="title" id="title" placeholder='News Title'>
	<input type="text" class='dt' name="post_date" id="post_date" placeholder='Published Date'>
	<select style='width:100px;' name="status" id="status">
		<option value="">All</option>
		<option value="1">Published</option>
		<option value="0">Not Published</option>
	</select>
	<button type="button" class='btn btn-info' id='search'><i class="fa fa-search"></i> Search</button>
</div>
<table id='current_news' class="table table-stripped">
	<thead>
		<tr>
			<th>Category</th>
			<th>Title</th>
			<th>Date</th>
			<th width='12%'>Display</th>
			<th width="15%">Action</th>
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
<!-- <script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/dataTables.bootstrap2.js"></script> -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
	//display job list in datatables
	table = $('#current_news').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}admin/current_news/current_news_list_dt",
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
		var cat=$('#category').val();
		var post_date=$('#post_date').val();
		var title=$('#title').val();
		var status=$('#status').val();
		var term={cat:cat,pdate:post_date,title:title,status:status};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable
	
	$('*[data-peak="1"]').parent('td').parent('tr').addClass('peaked');
	console.log($('*[data-peak="1"]').parent('td').parent('tr'));
	/**
	 * mark news as weekly peak
	 */
	$('#current_news').on('click','.btn-weekly-peak',function(e){
		e.preventDefault();
		var that=$(this);
		var id=that.data('id');
		stat=that.data('peak')=='1'?0:1;
		$.ajax({
			url: '{{ $base_url }}admin/current_news/add_as_weekly_peak',
			type: 'POST',
			data: {id: id,stat:stat}
		})
		.done(function(res) {
			if(stat=='1')
			{
				that.parent('td').parent('tr').addClass('peaked');
			}
			else{
				that.parent('td').parent('tr').removeClass('peaked');
			}
			
		});
	});//end mark news as weekly peak

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
			table.draw();
		});
	}
}
</script>
@stop