<div class="topheader">
        <div class="left">
            <h1 class="logo">PINACLE<span>TEST</span></h1>
            <span class="slogan">Justify your skills</span>
            

            
            <br clear="all" />
            
        </div><!--left-->
        
        <div class="right">
        	<!-- <div class="notification">
                <a class="count" href="<?php echo base_url();?>ajax/notifications.html"><span>9</span></a>
        	</div> -->
            <div class="userinfo">
            	<img src="<?php echo base_url();?>images/thumbs/avatar.png" alt="" />
                <span style="min-width: 120px"><?php echo $this->session->userdata('username'); ?></span>
            </div><!--userinfo-->
            
            <div class="userinfodrop">
            	<div class="avatar">
                	<a href="#"><img src="<?php echo base_url();?>images/thumbs/avatarbig.png" alt="" /></a>
                    
                </div><!--avatar-->
                <div class="userdata">
                	<h4 style="width: 100%"><?php echo $this->session->userdata('username'); ?></h4>
                    <span class="email"> <?php echo $this->session->userdata('email'); ?></span>
                    <ul>
                    	<li><a href="<?php echo base_url();?>member/account_setting">Edit Profile</a></li>                        
                        <!-- <li><a href="<?php echo base_url();?>membership_setting">Membership</a></li> -->
                        <!-- <li><a href="#">Account Settings</a></li> -->
                        <li><a href="help.html">Help</a></li>
                        <li><a href="<?php echo base_url()?>login/sign_out">Sign Out</a></li>
                    </ul>
                </div><!--userdata-->
            </div><!--userinfodrop-->
        </div><!--right-->
    </div><!--topheader-->