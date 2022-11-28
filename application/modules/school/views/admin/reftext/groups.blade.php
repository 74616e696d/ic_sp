<form method="POST" action="{{ $base_url }}school/admin/reftext/add_ref_group">
<table class="tbl_form">
	<tr>
		<td>
		<div class="input-prepend">
		<span class="add-on">Reference Group</span>
		<input type="text" required="required" id='txt_ref_group' name="txt_ref_group"/>
		</div>
		</td>
		<td style="padding-bottom:2px;">
		<button type="button" style="margin-top:-11px;" id='btnSaveGroup' class="btn" name="btnSaveGroup">
			<i class="icon-ok-circle"></i>Save
		</button></td>
	</tr>
</table>
</form>
<br/>

<!--start list of refgroups -->
<table width="50%" id='tblGroups' class="table table-striped table-bordered">
	<thead>
	<tr>
		<th>ID</th>
		<th>Group</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<!--end list of refgroups -->