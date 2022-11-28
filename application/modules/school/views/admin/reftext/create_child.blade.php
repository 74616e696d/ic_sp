<form method="POST" id='frmReftext' action="<?php echo base_url(); ?>school/admin/reftext/save_child_ref_text">
	<div class="msg"></div>
    <table cellpadding="2" class="tbl_form">
	    <tr>
	    	<th>Ref Group:</th>
	    	<td>
	    		<select name="ddlRefGroup">
	    		<option value="-1">-Select Group-</option>
	    		@if($ref_group)
	    		@foreach($ref_group as $rg)
	    		<option value="{{  $rg->id }}">{{  $rg->name }}</option>
	    		@endforeach
	    		@endif
	    	</select>
	    	</td>
	    </tr>	
	    <tr>
	    	<th>Parent Text</th>
	    	<td>
	    		<span class="badge">{{ reftext_model::get_text($ref_id) }}</span>
	    		<input type="hidden" name="hdn_parent" value="{{ $ref_id }}">
	    	</td>
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
			$('.msg').html(res);
			setTimeout(function(){
			  $('#addChildReftext').modal('hide')
			}, 1000);
			console.log('Saved successfully !');
		});
	});//end save reftext to db

});
</script>