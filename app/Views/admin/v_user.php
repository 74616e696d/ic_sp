<style>
	.checkbox{display:inline !important;}
	.checkbox input[type=checkbox]{float:none;}
</style>
<div>
	<?php render_message(); ?>
</div>
<form  class="form-horizontal" method="post" action="<?php echo base_url(); ?>admin/user/add">
	<label for="txt_user_name">User Name:</label>
	<input type="text" name="txt_user_name" id="txt_user_name" required="required" placeholder="user name">
	
	<label for="txt_password">Password:</label>
	<input type="password" name="txt_password" id="txt_password" required="required" placeholder="password">

	<label for="txt_con_pass">Confirm Password</label>
	<input type="password" name="txt_con_pass" id="txt_con_pass" required="required" placeholder="confirm password">
	
	<label for="txt_email">Email:</label>
	<input type="email" name="txt_email" id="txt_email" required="required" placeholder="email">
	<div>
	<label style="margin-left:0 !important;"><input class="pull-left" type="radio" name="rd_role" id="rd_role_admin" value="101">&nbsp;&nbsp;Admin</label>
	<label style="margin-left:0 !important;"><input class="pull-left" type="radio" name="rd_role" id="rd_role_operator" value="102">&nbsp;&nbsp;Operator</label>
	</div>
	<br/><br/>
	<button type="submit" class="btn btn-info"><i class="icon icon-ok-circle icon-white"></i>&nbsp;&nbsp;Save</button>
	<a href="<?php echo base_url(); ?>" class="btn btn-danger"><i class="icon icon-remove-circle icon-white"></i>&nbsp;&nbsp;Cancel</a>
</form>