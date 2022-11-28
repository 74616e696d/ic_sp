@extends('admin_master.layout')

@section('content')
<div id='msg'>
	<?php render_message(); ?>
</div>
<div class="form-inline">
	<input type="text" name="username" id="username" placeholder='User Email'>
	<input type="hidden" name="hdn_uid" id='hdn_uid'>
	<select name="ddl_role" id="ddl_role">
		<option value="-1">-Select User Type-</option>
		<option value="101">Admin</option>
		<option value="102">Operator</option>
		<?php if($mem_types){foreach ($mem_types as $mt) {?>
			<option value="<?php echo $mt->id;  ?>"><?php echo $mt->name; ?></option>
		<?php }} ?>
	</select>
	&nbsp;&nbsp;&nbsp;
	<span class="spn-rd">

	<label class="rd"><input type="radio" name="rd_active" id="rd_active" value="0">Active</label>&nbsp;
	<label class="rd"><input type="radio" name="rd_active" id="rd_inactive" value="1">Inactive</label>
	</span>


	&nbsp;&nbsp;
	<button id="btn-search" class="btn btn-info">
	<i class="icon icon-search icon-white"></i>&nbsp;Search</button>
</div>
<br/>
<div>
	<table id="tblUser" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>User</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Created at</th>
				<th>Last Login</th>
				<th>Role</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>


<div id="pass_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/user_list/change">
	<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Change Password</h3>
  	</div>
  	<div class="modal-body">
   
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-primary pull-left">Save</button>
  </div>
  </form>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/dataTables.bootstrap.min.css">
<style>
	.spn-rd{
		height:30px;
		line-height:30px;
		padding:2px;
		background:#f5f5f5;
	}
	.rd{
		height:25px;
		line-height: 25px;
		
	}
	.rd input{
		float: left;

		}

	.table
	{
			font-size:12px !important;
		}
	.table tbody tr td
	{
		font-size:11px;
	}

	#pass_dlg
	{
		width:300px;
		left:85%;
		top:25%;
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
	$(document).ready(function() {
		//display job list in datatables
		table = $('#tblUser').DataTable({
			"processing": true,
			"serverSide": true,
			"searching": true,
			"pageLength"	:50,
			// Load data for the table's content from an Ajax source
			"ajax": {
			    "url": "{{ $base_url }}admin/user_list/user_list_dt",
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
		$('#btn-search').click(function() {
			var mtype=$('#ddl_role').val();
			var email=$('#username').val();
			var status='';
			$('#rd_active').click(function(){ status=$(this).val(); });
			$('#rd_inactive').click(function(){ status=$(this).val(); });
			var term={mtype:mtype,email:email,status:status};
			table.search(JSON.stringify(term)).draw();
		});

		var role=$('#ddl_role'),
			st_active=$('input[name=rd_active]'),
			st_online=$('input[name=rd_online]'),
			skey1=-1,
			skey2=-1,
			skey3=-1,
			skey4=0;
			make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

		// $('#btn-search').attr('href',make_url);
		// role.change(function(){
		// 	skey1=$(this).children(':selected').val();
		// 	if(skey1!=-1){
		// 		make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
		// 	}else{
		// 		make_url='<?php echo base_url(); ?>admin/user_list/index/'+-1+'/'+skey2+'/'+skey3+'/'+skey4;
		// 	}

		// 	$('#btn-search').attr('href',make_url);
		// });

		st_active.click(function(){
			skey2=$('input[name=rd_active]:checked').val();
			if(skey2.length>0){
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
			}else{
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+-1+'/'+skey3+'/'+skey4;
			}

			$('#btn-search').attr('href',make_url);
		});

		st_online.click(function(){
			skey3=$('input[name=rd_online]:checked').val();
			if(skey3.length>0){
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
			}else{
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+-1+'/'+skey4;
			}

			$('#btn-search').attr('href',make_url);
		});

		$('.activate').click(function(){
			var status=0,
				ck_active=$(this),
				activation_text='',
				uname=$(this).val();
			ck_active.is(':checked')?status=1:status=0;
			ck_active.is(':checked')?activation_text='activate':activation_text='Not Active';

			$.ajax({
				url: '<?php echo base_url(); ?>admin/user_list/activate_user',
				type: 'GET',
				data:{st:status,usr:uname},
			})
			.done(function(msg) {
				$('#msg').html(msg);
				ck_active.next('span').text(activation_text);
			});
		
		});

		$('#pass_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});


	    $('#username').autocomplete({
	        source: function (request, response) {
	           $.ajax({
	               url:'<?php echo base_url(); ?>admin/upgrade_request/user_list',
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
	              $('#username').val(ui.item.label);
	              $('#hdn_uid').val(ui.item.value);
	        },
	        minLength: 2
	    });

	});
</script>

@stop