<form method="POST" id='frmReftext' action="<?php echo base_url(); ?>university/admin/reftext/add_ref_rext">
    <table cellpadding="2" class="tbl_form">
	    <tr>
	    	<th>Ref Group:</th>
	    	<td>
	    		<select name="ddlRefGroup">
	    		<option value="-1">-Select Group-</option>
				<?php
					$grp=$ref=='grp'?$ref_id:0;
				?>
	    		@if($ref_group)
	    		@foreach($ref_group as $rg)
	    		<option {{ $rg->id==$grp?'selected':'' }} value="{{  $rg->id }}">{{  $rg->name }}</option>
	    		@endforeach
	    		@endif
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
	    		@if($ref_group)
	    		@foreach($ref_group as $rg)
	    		<option value="{{  $rg->id }}">{{ $rg->name }}</option>
	    		@endforeach
	    		@endif
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
	    		<button type="button" id='btnSaveReftext' class="btn"><i class="icon-ok-circle"></i> Save </button>
	    		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    	</td>
	    </tr>
    </table>
</form>

<script type="text/javascript">
$(document).ready(function() {
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
			url:'<?php echo base_url(); ?>university/admin/reftext/get_ref_text_ddl',
			type:'POST',
			data:{groupid:gid},
			success:function(msg){
				$('#ddlParent').html(msg);
			}
		});
	});

	/**
	 * save reftext to db
	 */
	$('#btnSaveReftext').click(function(){
		var data=$('#frmReftext').serialize();
		var url=$('#frmReftext').attr('action');
		$.ajax({
			url: url,
			type: 'POST',
			data: data
		})
		.done(function(res) 
		{
			console.log('saved successfully!');	
		});
	});//end save reftext to db

});
</script>