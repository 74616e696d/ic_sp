<input type="hidden" name="hdn_id" value="<?php echo $member->id; ?>"/>
<label for="txt_membership_edit">Membership Type:</label>
<input type="text" name="txt_membership_edit" id="txt_membership_edit" 
required="required" value="<?php echo $member->name; ?>" placeholder="Membership Type"/>