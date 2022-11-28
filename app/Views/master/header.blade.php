<header class="header">
    <a href="{{$base_url}}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
       <!-- Iconpreparation -->
       <img id="logo" src="{{$base_url}}asset/frontend/new/img/logo-white.png" alt="Iconpreparation" />
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <!-- <a href="" class='btn visible-xs'>Signout</a> -->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="" style="color:#E6F101"><i class="fa fa-phone"></i> 01994336000</a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{$email}} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{$user_img}}" class="img-circle" alt="User Image" />
                            <p>
                                {{$username}}
                                <?php
                                $dt='';
                                if($creationdate)
                                {
                                    $date=date_create($creationdate);
                                    $dt=date_format($date,'M.   Y');
                                }
                                ?>
                                <small>Member since {{$dt}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                 
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{$base_url}}member/account_setting" class="btn btn-default" style='background:#0177BF;color:#f6f6f6 !important;'>Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{$base_url}}login/sign_out" class="btn btn-defult" style='background:#0177BF;color:#f6f6f6;'>Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>