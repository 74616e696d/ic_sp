<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online Exam||<?php if($title)echo $title; ?></title>

	</head>
	<body>
		<input type="hidden" name="hdn_id" value="<?php echo $reftxt->id;?>"/>
		<table cellpadding="2" class="tbl_form">
			<tr>
				<th>Ref Group:</th>
				<td>
					<select name="ddlRefGroupEdit">
					<option value="-1">-Select Group-</option>
					<?php if($ref_group){foreach($ref_group as $rg){ ?>
					<option <?php if($gid==$rg->id) echo "selected"; ?> value="<?php echo $rg->id; ?>"><?php echo $rg->name; ?></option>
					<?php }} ?>
				</select>
				</td>
			</tr>
			<?php if($parent_id!=0){
				echo '<tr>';
				echo '<th>Parent Text</th>';
				echo '<td>';
				echo '<input disabled type="text" name="txt_parent" value="'.$parent_txt.'"/>';
				echo '<input type="hidden" name="hdn_pid" value="'.$parent_id.'"/>';
				echo '</td>';
				echo '</tr>';
			 }?>	
			<tr>
				<th> Change Parent Ref Text:</th>
				<td><input type="checkbox" <?php if($reftxt->parent_id!=0)echo 'checked'; ?> id="ckParentEdit" name="ckParentEdit" value="1"/></td>
			</tr>
				<tr class="prntEdit">
				<th>Reference Group(To Filter):</th>
				<td>
					<select id="ddlRefGroupEditFilter">
					<option value="-1">-Select Group-</option>
					<?php if($ref_group){foreach($ref_group as $rg){ ?>
					<option value="<?php echo $rg->id; ?>"><?php echo $rg->name; ?></option>
					<?php }} ?>
				</td>
			</tr>
			<tr class="prntEdit">
				<th>Parent Ref Text:</th>
				<td>
				<select name="ddlParentEdit" id="ddlParentEdit">
				
				</select></td>
			</tr>
			<tr>
				<th>Ref Text:</th>
				<td><input type="text" name="txtRefTextEdit" value="<?php echo $reftxt->name; ?>" required="required" class="txt"/></td>
			</tr>
			<tr>
				<th>Display Order:</th>
				<td><input type="text" name="txtOrderEdit" value="<?php echo $reftxt->serial; ?>" class="input-small"/></td>
			</tr>
			<tr>
				<th>Visible:</th>
				<td><input type="checkbox" <?php if($reftxt->display)echo 'checked'; ?> name="ckDisplayEdit" value="1"/></td>
			</tr>
			</table>
	</body>
	
	<script type="text/javascript">
	//$(document).ready(function(){
		$('.prntEdit').hide();
		$('#ckParentEdit').removeAttr('checked');
		$('#ckParentEdit').click(function(){
			if($('#ckParentEdit').is(':checked'))
			{
				$('.prntEdit').show('1000');
			}else
			{
				$('.prntEdit').hide('1000');
			}
		});
		
		
		
		
		$('#ddlRefGroupEditFilter').change(function(){
		var gidEdit=$('#ddlRefGroupEditFilter option:selected').val();
		$.ajax({
			url:'<?php echo base_url(); ?>admin/edit_ref_text/get_ref_text_ddl',
			type:'POST',
			data:{groupid:gidEdit},
			success:function(msg){
				$('#ddlParentEdit').html(msg);
			}
			});
		});	
	//});
</script>
	
</html>