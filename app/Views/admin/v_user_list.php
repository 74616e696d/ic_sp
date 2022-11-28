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
</style>
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
	&nbsp;&nbsp;&nbsp;
	<span class="spn-rd">
		<label class="rd"><input type="radio" name="rd_online" id="rd_online" value="0">Online</label>&nbsp;
		<label class="rd"><input type="radio" name="rd_online" id="rd_offline" value="1">Offline</label>
	</span>
	&nbsp;&nbsp;
	<a href='#' id="btn-search" class="btn btn-info"><i class="icon icon-search icon-white"></i>&nbsp;Search</a>
</div>
<br/>
<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>User</th>
				<th>Email</th>
				<th>Creation Date</th>
				<th>Online Status</th>
				<th>Locked</th>
				<th>Last Login</th>
				<th>Role</th>
				<th>Active Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $users; ?>
		</tbody>
	</table>
	<?php echo $page; ?>
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

<script type="text/javascript">
	$(document).ready(function() {
		var role=$('#ddl_role'),
			st_active=$('input[name=rd_active]'),
			st_online=$('input[name=rd_online]'),
			skey1=-1,
			skey2=-1,
			skey3=-1,
			skey4=0;
			make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

		$('#btn-search').attr('href',make_url);
		role.change(function(){
			skey1=$(this).children(':selected').val();
			if(skey1!=-1){
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
			}else{
				make_url='<?php echo base_url(); ?>admin/user_list/index/'+-1+'/'+skey2+'/'+skey3+'/'+skey4;
			}

			$('#btn-search').attr('href',make_url);
		});

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
		        change:function( event, ui ) 
		        {
		        	 skey4=$('#hdn_uid').val();
		        	if(skey4>0)
		        	 {
		        	     make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;

		        	 }
		        	 else
		        	 {
		        	     make_url='<?php echo base_url(); ?>admin/user_list/index/'+skey1+'/'+skey2+'/'+skey3+'/'+0;

		        	 }
		        	$('#btn-search').attr('href',make_url);
		        },  
		        minLength: 2
		    });

	});
</script>