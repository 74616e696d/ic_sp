<?php $base_url="http://localhost:8080/OnlineTest/"; ?>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="{{$base_url}}"><i class="icon-location-arrow"></i>&nbsp;Admin Panel</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i>&nbsp;&nbsp;
                        {{--@if($username){{$username}}@endif --}}
                        <i class="caret"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="#">Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <!-- <a tabindex="-1" href="{{$base_url}}login/sign_out">Logout</a> -->
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="active">
                        <a href="{{$base_url}}admin/dashboard">Dashboard</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings <b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu" id="menu1">
                            <li>
                                <a href="{{$base_url}}admin/reference_text">Add Reference Text</a>
                            </li>
                             <li>
                                <a href="{{$base_url}}admin/ref_list">Reference Text</a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/order_ref_text">Order Reference Text</a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/membership">Membership</a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/member_setting">Member Setting</a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/exam_lock/lock_exam_view">Exam Lock Management</a>
                            </li>
                             <li>
                                <a href="{{$base_url}}admin/exam_lock/subject_lock_view">Subject Lock Management</a>
                            </li>
                            <li>
                                <a href="{{$base_url}}admin/exam_lock">Chapter Lock Management</a>
                            </li>
                          
                        </ul>
                    </li>
                    <li>
                        <a href="{{$base_url}}admin/manage_media">Manage Media</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users <i class="caret"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="{{$base_url}}admin/user">Create User</a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{$base_url}}admin/user_list">User List</a>
                            </li>
                            <li>
                                <a tabindex="-1" href="#">Permissions</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>