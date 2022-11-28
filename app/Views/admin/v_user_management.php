<ul class="nav nav-tabs" id="tab">
	<li><a href="#tab1">Setting</a></li>
	<li><a href="#tab2">All Users</a></li>
	<li><a href="#tab3">Group Wise Reference Text</a></li>
</ul>
<div class="tab-content">
	<div id="tab1" class="tab-pane">
 <a href='#' id='add_ans' role='button' data-target='#add_ans_dlg' data-toggle='modal' data-dismiss='modal'><i class='icon-plus-sign'></i></a>
		<table width="50%" class="table table-striped table-bordered">
		<thead>
		<tr>
		
			<th>User type</th>
			<th>Amount to pay</th>
			<th>Number of Exam(Max)</th>
			<th>List of Exam</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($user_list as $user){
		?>
			<tr>
				<td><?php echo $user->u_type;?></td>
				<td><?php echo $user->u_amount;?></td>
				<td><?php echo $user->max_num_exam	;?></td>
				<td><?php echo $user->exam_list;?></td>
				<td><a href="" class="btn" data-target='#add_ans_dlg' data-toggle='modal' data-dismiss='modal'><i class="icon-edit"></i>Edit</a></td>
			</tr>
		<?php
		}
		?>
		</tbody>
		</table>
	</div>
	<div id="tab2" class="tab-pane">
			<form method="POST" action="<?php echo base_url(); ?>admin/reference_text/add_ref_rext">
			<table cellpadding="2" class="tbl_form">
			<tr>
				<th>Ref Group:</th>
				<td>
					<select name="ddlRefGroup">
					<option value="-1">-Select Group-</option>
					<?php //if($ref_group){foreach($ref_group as $rg){ ?>
					<option value="<?php //echo $rg->id; ?>"><?php //echo $rg->name; ?></option>
					<?php //}} ?>
				</select>
				</td>
			</tr>	
			<tr>
				<th>Has Parent RefText:</th>
				<td><input type="checkbox" id="ckParent" name="ckParent" value="1"/></td>
			</tr>
			<tr class="prnt">
				<th>Reference Group(To Filter):</th>
				<td>
					<select id="ddlRefGroupFilter">
					<option value="-1">-Select Group-</option>
					<?php //if($ref_group){foreach($ref_group as $rg){ ?>
					<option value="<?php //echo $rg->id; ?>"><?php //echo $rg->name; ?></option>
					<?php //}} ?>
				</td>
			</tr>
			<tr class="prnt">
				<th>Parent Ref Text:</th>
				<td><select name="ddlParent" id="ddlParent">
				
				</select></td>
			</tr>
			<tr>
				<th>Ref Text:</th>
				<td><input type="text" name="txtRefText" required="required" class="txt"/></td>
			</tr>
			<tr>
				<th>Display Order:</th>
				<td><input type="text" name="txtOrder" class="input-small"/></td>
			</tr>
			<tr>
				<th>Visible:</th>
				<td><input type="checkbox" name="ckDisplay" value="1"/></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<button type="submit" class="btn">
						<i class="icon-ok-circle"></i>Save
					</button>
				</td>
			</tr>
			</table>
			</form>
			<br/>
			
	</div>
	<div id="tab3" class="tab-pane">
		
			<form method="POST" action="<?php echo base_url(); ?>admin/reference_text/index">
				<select style="margin-left:10%;" name="ddlGroupSearch">
				<option value="-1">--Search By Group--</option>
				<?php //if($ref_group){foreach($ref_group as $rgp){ ?>
				<option value="<?php //echo $rgp->id; ?>"><?php echo $rgp->name; ?></option>
				<?php //}} ?>
			</select>
			<button style="margin-top:-11px;" type="submit" class="btn" name="btn_search"><i class="btn-search"></i>search</button>
			</form>
			
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Reference Text</th>
						<th>Group</th>
						<th>Parent</th>
						<th>Order</th>
						<th>Visible</th>
						<th>Action</th>
					</tr>
				</thead>
				<?php //echo //$ref_text; ?>
			</table>
			<?php //echo //$make_page; ?>
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
</div>
 <div id="add_ans_dlg" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Configure Users</h3>
        </div>
        <div class="modal-body">
				<form method="POST" action="<?php echo base_url(); ?>admin/user_management/insert_user_setting">
						<label for="ck_display">User type</label>
						<input type="text" placeholder="Example:Gold" name="txttype" required />
						
						<label for="ck_display">Set Amount</label>
						<input type="text" placeholder="Example:2000 BDT" name="txtamount" required />
						
						<label for="ck_display">Number of Test</label>
						<input type="text" placeholder="Example:50" name="txttest" required />
						<?php
						print_r($test);
						?>
					<button type="submit" class="btn">
						<i class="icon-ok-circle"></i>Save
					</button>
				</form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
<script type="text/javascript">
   // $(document).ready(function(){
        $('#add_ans_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });
    //});

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tab li:eq(2) a').tab('show');
		$('#tab a').click(function(e){
			e.preventDefault();
			$(this).tab('show');
		});
		
		$('.prnt').hide();
		$('#ckParent').removeAttr('checked');
		$('#ckParent').click(function(){
			if($('#ckParent').is(':checked'))
			{
				$('.prnt').show('1000');
			}else
			{
				$('.prnt').hide('1000');
			}
		});
		
		$('#ddlRefGroupFilter').change(function(){
		var gid=$('#ddlRefGroupFilter option:selected').val();
		$.ajax({
			url:'<?php echo base_url(); ?>admin/reference_text/get_ref_text_ddl',
			type:'POST',
			data:{groupid:gid},
			success:function(msg){
				$('#ddlParent').html(msg);
			}
			});
		});
		
		
		//Search ReferenceText by Group
		
		//End search Reference Text By Group
	
		//Display Modal dialog
		$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});
		//End Display Modal Dialog
        //Maintain state of selected tab
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
        }

        // Change hash for page-reload
        $('.nav-tabs a').on('shown', function (e) {
            window.location.hash = e.target.hash;
        })
        //end Maintain state of selected tab

	});


</script>