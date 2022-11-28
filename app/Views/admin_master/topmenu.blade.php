<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
            </a>
            <a class="brand" href="{{$base_url}}">
                <i class="icon-location-arrow">
                </i>
                &nbsp;Admin Panel
            </a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user">
                            </i>
                            &nbsp;&nbsp;@if($username){{$username}}@endif
                            <i class="caret">
                            </i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="#">
                                    Profile
                                </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a tabindex="-1" href="{{$base_url}}login/sign_out">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="active">
                        <a href="{{$base_url}}admin/dashboard">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{$base_url}}member/dashboard">
                            User Panel
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                            Settings
                            <b class="caret">
                            </b>
                        </a>
                        <ul class="dropdown-menu" id="menu1">
                            <li>
                                <a href="{{$base_url}}admin/manage_question">
                                    Manage Question
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/reference_text">
                                    Add Reference Text
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/ref_list">
                                    Reference Text
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>admin/order_ref_text">
                                    Order Reference Text
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/membership">
                                    Membership
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/member_setting">
                                    Member Setting
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/exam_lock/lock_exam_view">
                                    Exam Lock Management
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/exam_lock/subject_lock_view">
                                    Subject Lock Management
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/exam_lock">
                                    Chapter Lock Management
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/instruction">
                                    Instructions
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/events">
                                    Upcoming Events
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/event_post">
                                    Event Post
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/manage_forum_comment">
                                    Manage Post Comments
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/university">
                                    Manage University
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/asked_for_expert">
                                    Ask To Expert
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="" data-toggle='dropdown' class='dropdown-toggle'>
                            Reports
                            <b class='caret'>
                            </b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{$base_url}}admin/model_quiz_report">
                                    Model Quiz Report
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="" role='button' class='dropdown-toggle' data-toggle='dropdown'>
                            Manage Expert
                            <i class="caret">
                            </i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ $base_url }}admin/expert/expert_quiz">Manage Expert Quiz</a></li>
                           <li><a href="{{ $base_url }}admin/expert/quiz_question">Manage Expert Quiz Question</a></li>
                           <li><a href="{{ $base_url }}admin/expert/tags_manager">Manage Expert Tags</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="" role='button' class='dropdown-toggle' data-toggle='dropdown'>
                            Manage
                            <i class="caret">
                            </i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>admin/manage_media">
                                    Manage Media
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/current_news_category">
                                    Current News Category
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/current_news">
                                    Current News
                                </a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/job/category">
                                    Job Category
                                </a>
                            </li>
                         <!--    <li>
                             <a href="{{$base_url}}admin/news/news_list">
                                 Manage Jobs
                             </a>
                         </li> -->
                            <li>
                            <a href="{{ $base_url }}admin/company_info">Manage Company Info</a>
                            </li>
                            <li><a href="{{ $base_url }}admin/job/job_list">Manage Jobs</a></li>

                                <li>
                                    <a href="{{$base_url}}admin/todays_happening">
                                        Manage On this days
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$base_url}}admin/upcoming_model_test">
                                        Manage Upcoming Model Test
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$base_url}}admin/cvtemp">
                                        Manage CV Template
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$base_url}}admin/job_exam_mapping">
                                        Exam Map To Company
                                    </a>
                                </li>
                                <li><a href="{{ $base_url }}admin/roadmap">Manage Crash Course</a></li>
                                <li><a href="{{ $base_url }}admin/roadmap/details">Manage Crash Course Details</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                                Users
                                <i class="caret">
                                </i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a tabindex="-1" href="{{$base_url}}admin/manage_forum">
                                        Manage Forum
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="{{$base_url}}admin/user">
                                        Create User
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="{{$base_url}}admin/user_list">
                                        User List
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="#">
                                        Permissions
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                                System
                                <i class="caret">
                                </i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a tabindex="-1" href="{{$base_url}}admin/manage_cache">
                                        Manage Cache
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.nav-collapse -->
                <form accept-charset="UTF-8" class='navbar-form pull-right' action="{{ $base_url }}admin/hints/index" method="post">
                    <input type="text" class="span2" name="hints_search_box" id='hints_search_box' placeholder="Hints"/>
                    <button type="submit" class="btn btn-small">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
