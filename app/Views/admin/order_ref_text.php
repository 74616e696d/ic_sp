<style>
	#sort li:hover
	{
		cursor:move;
	}
</style>

<form class='form-horizontal' method="post" action="<?php echo base_url(); ?>admin/order_ref_text/save_order">
<div class="control-group">
	<label for="txt_ref_group" class="control-label">Refefence Group:</label>
	<div class="controls">
		<select name="ddl_ref_group" id="ddl_ref_group">
		<option value="-1">Select Ref Group</option>
			<?php 
			if($groups)
			{
				foreach($groups as $gp)
				{
					echo "<option value='$gp->id'>{$gp->name}</option>";
				}
			} 
			?>
		</select>

		
	</div>
</div>

<div class="control-group">
	<label for="ddl_parent" class="control-label">Ref Text:</label>
	<div class="controls">
		<select name="ddl_parent" id="ddl_parent">
			<option value="-1">Select Parent(If Any)</option>
		</select>
	</div>
</div>
<div class="control-group">
	<label class='control-label' for="ck_exclude">Exclude Group:</label>
	<div class="controls">
	<input type="checkbox" name="ck_exclude" id="ck_exclude" value='1'>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button id='btn' class="btn btn-info"><i class="fa fa-search"></i>&nbsp;Search</button>
	</div>
</div>
<div id='texts'>
	<ul id='sort' class='unstyled list-group'>
		
	</ul>
</div>
</form>

<script type='text/javascript'>
	$(document).ready(function() {
		$('#ddl_ref_group').click(function(){
			var gid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/order_ref_text/get_text_by_group',
				type: 'POST',
				data: {groupid: gid},
			})
			.done(function(data) {
				$('#ddl_parent').html(data);
			});
			
		});

		var cked=false;

		$('#ck_exclude').click(function(){
			cked=$('#ck_exclude').is(':checked')?true:false;
		});

		$('#btn').click(function(e){
			e.preventDefault();
			var gp=$('#ddl_ref_group').val(),
				prnt=$('#ddl_parent').val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/order_ref_text/search_ref_text',
				type: 'POST',
				data: {gp:gp,prnt:prnt,ck:cked},
			})
			.done(function(data) 
			{
				$('#sort').html(data);
			});
			
		});

		$( "#sort" ).sortable();

	});
	
</script>