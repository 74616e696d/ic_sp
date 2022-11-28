@extends('admin.master.master')

@section('content')
<ul class="nav nav-tabs">
	<li class='active'><a href="#tab1" data-toggle="tab">Reference Text</a></li>
	<li><a href="#tab2" data-toggle="tab">Reference Group</a></li>
</ul>
<div class="tab-content">
	<div id="tab1" class="tab-pane active fade in">
		<a href="{{ $base_url }}school/admin/reftext/new_ref_text" data-target='#addReftext' data-toggle='modal'  class="btn btn-success pull-right"><i class="fa fa-plus"></i> New Reference Text</a>
		<div class="form-inline">
			<input type="text" name="name" id="name" placeholder="Name">
			<select name="group" id="group">
				<option value="">-All Reference Group-</option>
				@if($ref_group)
				@foreach($ref_group as $group)
				<option value="{{ $group->id }}">{{ $group->name }}</option>
				@endforeach
				@endif
			</select>

			<button type='button' id='btnSearch' class="btn btn-default"><i class="fa fa-search"></i> Search</button>
		</div>
		<table width="100%" id='tblRefText' class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Group</th>
					<th>Parent</th>
					<th>Order</th>
					<th width="15%">Action</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

	</div>
	<div id="tab2" class="tab-pane fade in">
		@include('admin.reftext.groups')
	</div>

</div>
	<div id="edit_dlg" class="modal hide fade">
		<form method="POST" action="<?php echo base_url(); ?>admin/edit_ref_text/update">
			<div class="modal-header">
	   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    	<h3 id="myModalLabel">Edit Reference Text</h3>
	  	</div>
	  	<div class="modal-body">
	   	 <p>One fine body…</p>
	 	 </div>
	  	<div class="modal-footer">
	    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    	<button type="submit" class="btn btn-primary">Save changes</button>
	  </div>
	  </form>
	</div>

<!--start modal to add new reference text -->
<div id="addReftext" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Create Reference Text</h3>
	  </div>
	  <div class="modal-body">
	  </div>
</div>
<!--end modal to add new reference text -->


<!--start modal to add new reference text -->
<div id="addChildReftext" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Create Reference Text</h3>
	  </div>
	  <div class="modal-body">
	  </div>
</div>
<!--end modal to add new reference text -->


<!--start modal to add edit reference text -->
<div id="addEditReftext" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Edit Reference Text</h3>
	  </div>
	  <div class="modal-body">
	  </div>
</div>
<!--end modal to add edit reference text -->

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
		.tab-content{
			overflow: hidden;
		}
	</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery.cookie.js'></script>
<script type="text/javascript">
	$(document).ready(function(){
	load_ref_groups();
	 /**
	 * save refgroup
	 */
	$('#btnSaveGroup').click(function(){
		var group=$('#txt_ref_group').val();
		$.ajax({
			url: '{{ $base_url }}school/admin/reftext/add_ref_group',
			type: 'POST',
			data: {group: group}
		})
		.done(function(res) {
			load_ref_groups();
			$('#txt_ref_group').val('');
		});

	});

	//display job list in datatables
	table = $('#tblRefText').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"pageLength":20,
		"pagingType": "full_numbers",
		// Load data for the table's content from an Ajax source
		"ajax": {
		    "url": "{{ $base_url }}school/admin/reftext/ref_list_dt",
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
		var name=$('#name').val();
		var group=$('#group').val();
		var term={name:name,group:group};
		table.search(JSON.stringify(term)).draw();
	});
	//end search datatable

	$('#addReftext').on('hidden',function(){
		$(this).removeData('modal');
		table.draw();
	});

	$('#addChildReftext').on('hidden',function(){
		$(this).removeData('modal');
		table.draw();
	});

	$('#addEditReftext').on('hidden',function(){
		$(this).removeData('modal');
		table.draw();
	});

	//Display Modal dialog
	$('#edit_dlg').on('hidden', function () {
		$(this).removeData('modal');
		table.draw();
	});
	//End Display Modal Dialog

   //Maintain state of selected tab
   $('a[data-toggle="tab"]').on('shown', function(e){
	//save the latest tab using a cookie:
	$.cookie('last_tab', $(e.target).attr('href'));

	});
	//activate latest tab, if it exists:
	var lastTab = $.cookie('last_tab');
	if (lastTab) {
    	$('a[href=' + lastTab + ']').tab('show');
	}
    //end Maintain state of selected tab

    //creating search url
    var skey=$('#ddlGroupSearch').val(),
    	curUri="<?php echo base_url();?>admin/reference_text/index/"+skey;

    $('#btn_search').attr('href',curUri);

    $('#ddlGroupSearch').change(function(){

    	if($('#ddlGroupSearch').val()!=-1)
    	{
    	skey=$('#ddlGroupSearch').val();
    	curUri='<?php echo base_url();?>admin/reference_text/index/'+skey;
    	}
    	else
    	{
    		curUri='<?php echo base_url();?>admin/reference_text/index/-1';
    	}

    	$('#btn_search').attr('href',curUri);

    });
    //end creating search url

	});

/**
 * ref refgroup
 */
function load_ref_groups()
{
	$.ajax({
		url: '{{ $base_url }}school/admin/reftext/ref_group_table',
		type: 'GET'
	})
	.done(function(res) {
		$('#tblGroups tbody').html(res);
	});
}
</script>
@stop
