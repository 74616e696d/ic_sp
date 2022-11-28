@extends('admin_master.layout')

@section('content')
<div class="row-fluid">
	<div class="box span4">
		<h4>Total Attempted</h4>
		<span class='badge badge-success'>{{$total_attempt}}</span>
	</div>
	<div class="box span4">
		<h4>Todays Attempt</h4>
		<span class="badge badge-info">{{$todays_attempt}}</span>
	</div>
	<div class='box span4'>
		<h4>Current Month Attempt</h4>
		<span class="badge badge-warning">{{$monthly_attempt}}</span>
	</div>
</div>

<div class="row-fluid">
	<br>
		<div class="form-inline">
			<input type="text" name="user" id="user" placeholder='Email'>
			<input type="text" name="quiz_name" id="quiz_name" placeholder='Quiz Name'>
			<input type="text" name="dt1" class='dt' id="dt1" placeholder="From Date">
			<input type="text" name="dt2" class='dt' id="dt2" placeholder="To Date">
			<input type="hidden" name="hdn_uid" id="hdn_uid">
			<button id="btn_search" class="btn btn-info" type="button" title='Search'><i class="fa  fa-search"></i></button>
			<button type="button" id='btn_reset' class="btn btn-default" title='Reset'><i class="fa fa-times"></i></button>
		</div>
		<br>
		
		<table id='tblModelQuiz' class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Sl.</th>
					<th>Model Test</th>
					<th>User Email</th>
					<th>Date</th>
					<th class='text-right'>Total Questions</th>
					<th>Correct</th>
					<th>Wrong</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/jquery.dataTables.css">
<style>
	.table
	{
		font-size:12px !important;
		width: 100% !important;
	}
	.table tbody tr td
	{
		font-size:11px;
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

	.box{
		/*width:28%;*/
		float: left;
		text-align: center;
		padding: 15px;
		border:1px solid #f6f6f6;
		box-shadow: 1px 1px 1px #ccc;
	}
	.box h4{
		font-weight: normal;
	}
	.box .badge{
		padding: 10px;
	}
	input[type='text']{
		width:20%;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dt1').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});
		$('#dt2').datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd'});

		//display quiz result list in datatables
		table = $('#tblModelQuiz').DataTable({
			"processing":true,
			"serverSide":true,
			"searching": true,
			"pageLength":30,
			// Load data for the table's content from an Ajax source
			"ajax": {
			    "url": "{{ $base_url }}admin/model_quiz_report/result_dt",
			    "type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [
			{
			    "targets": [ -1 ], //last column
			    "orderable": false, //set not orderable
			},
			],
		});//end display quiz result list in datatables
		
		//search datatable
		$('#btn_search').click(function() {
			var email=$('#user').val();
			var dt1=$('#dt1').val();
			var dt2=$('#dt2').val();
			var quiz=$('#quiz_name').val();
			var term={email:email,dt1:dt1,dt2:dt2,quiz:quiz};
			table.search(JSON.stringify(term)).draw();
		});

		$('#btn_reset').click(function(){
			$('input[type="text"]').val('');
			var email=$('#user').val();
			var dt1=$('#dt1').val();
			var dt2=$('#dt2').val();
			var quiz=$('#quiz_name').val();
			var term={email:email,dt1:dt1,dt2:dt2,quiz:quiz};
			table.search(JSON.stringify(term)).draw();
		});

		$('#user').autocomplete({
		    source: function (request, response) {
		       $.ajax({
		           url:'{{ $base_url }}admin/upgrade_request/user_list',
		           type: 'GET',
		           dataType: 'json',
		           data: request,
		           success: function (data) {
		               response($.map(data, function (item) { 
		                    return {
		                        label: item.email,
		                        value: item.id
		                    };
		               }));
		           }
		       });
		    },
		     select: function(event, ui) {
		          event.preventDefault();
		          $('#user').val(ui.item.label);
		          $('#hdn_uid').val(ui.item.value);
		    },
		    change:function( event, ui ) {
		    	
		    },  
		    minLength: 2
		});
	});
</script>
@stop