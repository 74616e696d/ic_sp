		<style>
		#pass_content{
			background:#f5f5f5;
			padding:5px;
		}
		.checkbox {
			padding-left:0;
		}
		hr{
			margin-top:10px;
		}
		.tab-pane{
			padding-left:20px;
		}
		.badge{
			background:#66A54C;
			padding:6px 7px;
		}
		</style>
		<div>
			<?php render_message();
			 $this->my_validation->display_message();
			 ?>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
			<li><a href="#point" data-toggle="tab">Point</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
			<h3>Profile Of <?php echo $user->full_name; ?></h3><hr>
			<form class='form-horizontal form-custom' method="post" action="<?php echo base_url(); ?>member/profile/save" enctype="multipart/form-data">
			<input type="hidden" name="hdn_uid" id="hdn_uid" value="<?php echo $user->id; ?>">
			<div class="form-group">
			<?php
				$img_url=base_url().'asset/img/no-image.jpg';
				if(!empty($user->photo))
				{
					$img_url=base_url().'asset/images/upload/'.$user->photo;
				}
			 ?>
				<img width="150" height="150" src="<?php echo $img_url; ?>" alt="No Image" class="thumbnail">
				<input type="hidden" name="hdn_old_img" value="<?php echo $user->photo; ?>">
				<input type="hidden" name="hdn_new_img" id="hdn_new_img" value="">
				<label for="fl_image">Picture</label>
				<input type="file" name="fl_image" id="fl_image"/>
			</div>
			<div class="form-group">
			<label for="txt_user">User Name:</label>
			<input type="text" class='form-control' name="txt_user" id="txt_user" value='<?php echo $user->user_name; ?>'>
			</div>

			<div class="checkbox">
			<label>
			<input type="checkbox" value="1" style="margin-left:22px;width:10px;height:10px;" name="ck_display" id="ck_display">Change Password</label>
			</div>
			<div id="pass_content">
		     <div class="form-group">
		     	<label for="txt_pass">Old Password:</label>
		     	<input type="password" class="form-control" name="txt_old_pass" id="txt_pass" placeholder="Old Password">
		     </div>
		     <div class="form-group">
		     	<label for="txt_con_pass">New Password:</label>
		     	<input type="password" class="form-control" name="txt_new_pass" id="txt_con_pass" placeholder="New Password">
		     </div>
		    </div>
			<div class="form-group">
			<label for="txt_full_name">Full Name:</label>
			<input type="text" class='form-control' name="txt_full_name" id="txt_full_name" value="<?php echo $user->full_name; ?>">
			</div>

			<div class="form-group">
				<label for="txt_email">Email:</label>
				<input type="email" class='form-control' name="txt_email" id="txt_email" value="<?php echo $user->email; ?>">
			</div>

			<div class="form-group">
				<label for="ddl_mem_type">Membership Type</label>
				<select name="ddl_mem_type" class="form-control" id="ddl_mem_type">
		 			<option value="-1">Select Membership</option>
		 			<?php if($members){foreach ($members as $m) {
		 				$selected=$m->id==$user->mem_type?'selected':'';
		 				echo "<option {$selected}  value='{$m->id}'>{$m->name}</option>";
		 			}}?>
		 		</select>
			</div>
		
			<div class="form-group">
				<label for="txt_address">Address:</label>
				<textarea name="txt_address" id="txt_address" class='form-control' cols="30" rows="10"><?php echo $user->address; ?></textarea>
			</div>
			
			<div class="form-group">
				<label for="txt_phone">Phone:</label>
				<input type="text" class="form-control" name="txt_phone" id="txt_phone" value="<?php echo $user->phone; ?>">
			</div>
			<button type="submit" class='btn btn-info'><i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Save Changes</button>
			</form>
		</div> <!-- End Of Tab1 -->
		<div class="tab-pane fade in" id="point">
			<h3>Your Points</h3><hr>
			<ul class="list-group">
				<li class="list-group-item">
					<span class="badge">100</span>
					Your Points
				</li>
			</ul>
			<div class="list-group">
			<a href="" class="list-group-item active">Get Points</a>
			<a  class="list-group-item" href="">Purchase</a>
			<a  class="list-group-item" href="">Invite</a>
			</div>
		</div> <!-- End Of Tab2 -->
	</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#fl_image').change(function(){
			var img_name=$(this).val();
			$('#hdn_new_img').val(img_name);
		});

		$('#pass_content').css('display','none');
		$('#ck_display').click(function(){
			
			if($(this).is(':checked'))
			{
				$('#pass_content').show(1000);
			}
			else
			{
				$('#pass_content').hide(1000);
			}
		});
	});
</script>