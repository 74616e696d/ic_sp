@extends('admin_master.layout')

@section('content')
<div class="form-inline">
	<select name="category" id="category">
		<option value="">Select Category</option>
		@if($cats)
		    @foreach($cats as $ct)
		    <?php $selected=$selected_cat==$ct->id?'selected':''; ?>
		    <option {{ $selected }}  value="{{$ct->id}}">{{$ct->name}}</option>
		    @endforeach
		@endif
	</select>
	<select name="model_test" id="model_test">
		<option value="">Select Model Test</option>
	</select>
	<input type="text" name="txt_ques" id="txt_ques">
	<button type='button' id='btn-search' class='btn btn-info'>
		<i class="fa fa-search"></i>
		Search
	</button>
	<br><br>
</div>
<table id="qlist" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Question</th>
			<th>Options</th>
			<th>Subject</th>
			<th width="18%">Action</th>
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
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/dataTables.bootstrap.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/common.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	// start datatable
    table = $('#qlist').DataTable({
      "processing": true, 
      "serverSide": true, 
      "searching": true,
      "pageLength": 200,
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{ $base_url }}admin/manage_model_test_ques/dt_qlist",
          "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [
      {
        "targets": [ -1 ], //last column
        "orderable": false, //set not orderable
      },
      ],
    });

   
    //search in datatable
    $('#btn-search').click(function(){
    	var test_cat=$('#category').val();
    	var test_name=$('#model_test').val();
    	var ques=$('#txt_ques').val();
    	var term={test_name:test_name,ques:ques};
    	table.search(JSON.stringify(term)).draw();
    });//end search in datatable

    //get model test names on  by category
    $('#category').change(function(event) {
    	var cat_id=$(this).val();
    	$.ajax({
    		url: '{{$base_url}}admin/manage_model_test_ques/get_model_test',
    		type: 'POST',
    		data: {eid:cat_id}
    	})
    	.done(function(res) {
    		$('#model_test').html(res);
    	});
    	
    });//end get model test name by category


  });

function edit_question(id)
{
	var url='{{ $base_url }}admin/edit_question/index/'+id;
	window.open(url, '_blank');
}

function delete_question(id)
{
	var conf=confirm('Are you sure to delete ??');
	if(conf)
	{
		$.ajax({
			url: '{{ $base_url }}admin/manage_model_test_ques/delete_question_dt',
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