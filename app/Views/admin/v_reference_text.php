<ul class="nav nav-tabs">
	<li><a href="#tab1" data-toggle="tab">Reference Group</a></li>
	<li><a href="#tab2" data-toggle="tab">Reference Text</a></li>
	<li class="active"><a href="#tab3" data-toggle="tab">Group Wise Reference Text</a></li>
</ul>
<div class="tab-content">
	<div id="tab1" class="tab-pane fade in">
		<form method="POST" action="<?php echo base_url(); ?>admin/reference_text/add_ref_group">
		<table class="tbl_form">
			<tr>
				<td>
				<div class="input-prepend">
				<span class="add-on">Reference Group</span>
				<input type="text" required="required" name="txt_ref_group"/>
				</div>
				</td>
				<td style="padding-bottom:2px;">
				<button type="submit" style="margin-top:-11px;" class="btn" name="btnSaveGroup">
					<i class="icon-ok-circle"></i>Save
				</button></td>
			</tr>
		</table>
		</form>
		<br/>
		<table width="50%" class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>ID</th>
			<th>Group</th>
			<th>Action</th>
		</tr>
		</thead>
		<?php if($ref_group){foreach($ref_group as $rg){ ?>
			<tr>
				<td><?php echo $rg->id; ?></td>
				<td><?php echo $rg->name; ?></td>
				<td>
				<a href="" class="btn"><i class="icon-edit"></i>Edit</a>
				</td>
			</tr>
		<?php }} ?>
		</table>
	</div>
	<div id="tab2" class="tab-pane fade in">
			<form method="POST" action="<?php echo base_url(); ?>admin/reference_text/add_ref_rext">
			<table cellpadding="2" class="tbl_form">
			<tr>
				<th>Ref Group:</th>
				<td>
					<select name="ddlRefGroup">
					<option value="-1">-Select Group-</option>
					<?php if($ref_group){foreach($ref_group as $rg){ ?>
					<option value="<?php echo $rg->id; ?>"><?php echo $rg->name; ?></option>
					<?php }} ?>
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
					<?php if($ref_group){foreach($ref_group as $rg){ ?>
					<option value="<?php echo $rg->id; ?>"><?php echo $rg->name; ?></option>
					<?php }} ?>
					</select>
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
	<div id="tab3" class="tab-pane fade in">
		
			<!--<form method="POST" action="<?php echo base_url(); ?>admin/reference_text/index">-->
				<select style="margin-left:10%;" name="ddlGroupSearch" id='ddlGroupSearch'>
				<option <?php if($selected_index=='-1')echo 'selected'; ?> value="-1">--Search By Group--</option>
				<?php if($ref_group){foreach($ref_group as $rgp){ ?>
				<option value="<?php echo $rgp->id; ?>" <?php if($selected_index==$rgp->id)echo 'selected'; ?>><?php echo $rgp->name; ?></option>
				<?php }} ?>
			</select>
			<a href="<?php echo $_SERVER['REQUEST_URI'] ?>/" style="margin-top:-11px;" class="btn" id="btn_search"><i class="btn-search"></i>search</a>
			<!--</form>-->
			
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
				<?php echo $ref_text; ?>
			</table>
			<?php echo $make_page; ?>
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

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery.cookie.js'></script>
<script type="text/javascript">
	$(document).ready(function(){
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


</script>