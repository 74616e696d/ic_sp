<form method="POST" id='frmReftext' action="<?php echo base_url(); ?>school/admin/reftext/update">
	<div class="msg"></div>
	<input type="hidden" name="hdn_id" value="{{ $reftext->id }}">
    <table cellpadding="2" class="tbl_form">
	    <tr>
	    	<th>Ref Group:</th>
	    	<td>
	    		<select name="ddlRefGroup">
	    		<option value="-1">-Select Group-</option>
	    		@if($ref_group)
	    		@foreach($ref_group as $rg)
	    		<option {{ $reftext->group_id==$rg->id?'selected':'' }} value="{{  $rg->id }}">
	    		{{  $rg->name }}</option>
	    		@endforeach
	    		@endif
	    	</select>
	    	</td>
	    </tr>	
	    <tr>
	    	<th>Has Parent RefText:</th>
	    	<td>
	    	<input type="checkbox" id="ckParent" {{ ($reftext->parent_id>0 && !empty($reftext->parent_id))?'checked':'' }} name="ckParent" value="1"/>
	    	</td>
	    </tr>
	    <tr class="prnt">
	    	<th>Reference Group(To Filter):</th>
	    	<td>
	    		<?php
	    		$group=reftext_model::get_group_id($reftext->parent_id);
	    		?>
	    		<select id="ddlRefGroupFilter">
	    		<option value="-1">-Select Group-</option>
	    		@if($ref_group)
	    		@foreach($ref_group as $rg)
	    		<option {{ $group==$rg->id?'selected':'' }} value="{{  $rg->id }}">{{ $rg->name }}</option>
	    		@endforeach
	    		@endif
	    		</select>
	    	</td>
	    </tr>
	    <tr class="prnt">
	    	<th>Parent Ref Text:</th>
	    	<td>
	    	<select name="ddlParent" id="ddlParent">
	    	</select>
	    	</td>
	    </tr>
	    <tr>
	    	<th>Ref Text:</th>
	    	<td><input type="text" name="txtRefText" required="required" value="{{ $reftext->name }}" class="txt"/></td>
	    </tr>
	    <tr>
	    	<th>Display Order:</th>
	    	<td><input type="text" name="txtOrder" class="input-small" value="{{ $reftext->serial }}"/></td>
	    </tr>
	    <tr>
	    	<th>Visible:</th>
	    	<td><input type="checkbox" name="ckDisplay" {{ $reftext->display?'checked':'' }} value="1"/></td>
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

	show_hide_prnt();
	$('#ckParent').click(function(){
		show_hide_prnt();
	});
	var parent_id='{{ $reftext->parent_id }}';
	get_items_by_group($('#ddlRefGroupFilter option:selected').val(),parent_id);
	$('#ddlRefGroupFilter').change(function(){
		var gid=$('#ddlRefGroupFilter option:selected').val();
		
		get_items_by_group(gid,0);
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
			  $('#addEditReftext').modal('hide')
			}, 1000);
			console.log('saved successfully!');	
		});
	});//end save reftext to db

});

function show_hide_prnt()
{
	if($('#ckParent').is(':checked'))
	{
		$('.prnt').show('1000');
	}else
	{
		$('.prnt').hide('1000');
	}
}

/**
 * get reftext by group
 */
function get_items_by_group(gid,sel)
{
	$.ajax({
		url:'<?php echo base_url(); ?>school/admin/reftext/get_ref_text_ddl',
		type:'POST',
		data:{groupid:gid,sel:sel},
		success:function(msg){
			$('#ddlParent').html(msg);
		}
	});
}
</script>