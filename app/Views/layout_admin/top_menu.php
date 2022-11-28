<?php
 $user = $this->session->userdata('logged_in');
?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo base_url(); ?>"><i class="icon-location-arrow"></i>&nbsp;Admin Panel</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i>&nbsp;&nbsp;<?php if($this->session->userdata('username')){echo $this->session->userdata('username');}?> <i class="caret"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="#">Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a tabindex="-1" href="<?php echo base_url();?>login/sign_out">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="active">
                        <a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>member/dashboard">User Panel</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings <b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu" id="menu1">
                             <li>
                                <a href="<?php echo base_url(); ?>admin/manage_question">Manage Question</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>admin/reference_text">Add Reference Text</a>
                            
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>admin/ref_list">Reference Text</a>
                            
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>admin/order_ref_text">Order Reference Text</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/membership">Membership</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/member_setting">Member Setting</a>
                            </li>
                             <li>
                                <a href="<?php echo base_url(); ?>admin/exam_lock/lock_exam_view">Exam Lock Management</a>
                            </li>
                             <li>
                                <a href="<?php echo base_url(); ?>admin/exam_lock/subject_lock_view">Subject Lock Management</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/exam_lock">Chapter Lock Management</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/instruction">Instructions</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/events">Upcoming Events</a>
                            </li>
                             <li>
                                <a href="<?php echo base_url(); ?>admin/event_post">Event Post</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/manage_forum_comment">Manage Post Comments</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/university">Manage University</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/asked_for_expert">Ask To Expert</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="" data-toggle='dropdown' class='dropdown-toggle'>Reports <b class='caret'></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>admin/model_quiz_report">Model Quiz Report</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>admin/manage_media">Manage Media</a>
                    </li>
                   
                   <li class="dropdown">
                   <a href="" role='button' class='dropdown-toggle' data-toggle='dropdown'>Manage <i class="caret"></i></a>
                   <ul class="dropdown-menu">
                       <li><a href="<?php echo base_url(); ?>admin/current_news_category">Current News Category</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/current_news">Current News</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/news/category">Job Category</a></li>
                        <<!-- li><a href="<?php echo base_url(); ?>admin/news/news_list">Manage Jobs</a></li> -->
                       <li>
                       <a href="<?php echo base_url(); ?>admin/company_info">Manage Company Info</a>
                       </li>
                        <li><a href="<?php echo base_url(); ?>admin/job/job_list">Manage Jobs</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/todays_happening">Manage On this days</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/upcoming_model_test">Manage Upcoming Model Test</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/cvtemp">Manage CV Template</a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/job_exam_mapping">
                                Exam Map To Company
                            </a>
                        </li>
                   </ul>
                   </li>

                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users <i class="caret"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_forum">Manage Forum</a>
                            </li>
                            <li>
                                <a tabindex="-1" href="<?php echo base_url(); ?>admin/user">Create User</a>
                            </li>
                            <li>
                                <a tabindex="-1" href="<?php echo base_url(); ?>admin/user_list">User List</a>
                            </li>
                            <li>
                                <a tabindex="-1" href="#">Permissions</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">System <i class="caret"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_cache">Manage Cache</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>