   <nav class="navbar navbar-default" >
        <div class="container container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{$base_url}}">
                <img src="{{$base_url}}asset/frontend/new/img/logo.png" alt="Iconpreparation">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
            <!--     <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul> -->
                <ul class="nav navbar-nav navbar-right navbar-home">
                    <li><a href="{{$base_url}}">Home</a></li>
                    <li><a href="" lass="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Module <span class="caret"></span></a>
                        <ul class="dropdown-menu menu-module">
                            <li><a data-module='bcs'>BCS</a></li>
                            <li><a data-module='bank'>BANK</a></li>
                            <li><a data-module='govt'>GOVT. JOB</a></li>
                            <li><a data-module='teacher'>TEACHER'S REG</a></li>
                            <li><a data-module='mba'>MBA</a></li>
                        </ul>
                    </li>
                    <li><a href="{{$base_url}}index/news_details">Job Circular</a></li>
                    <li><a href="{{$base_url}}current_news">Current News</a></li>
                    <li><a href="{{$base_url}}forum/forum/posts">Forum</a></li>
                    @if(!$is_auth)
                    <li ><a href="{{$base_url}}public/user_reg" class='btn btn-primary btn-sm btn-login'>SIGN UP</a></li>
                    @else
                    @if($is_admin)
                    <li ><a target='_blank' href="{{$base_url}}admin/dashboard">Admin Panel</a></li>
                    @endif
                    <li><a href="{{$base_url}}member/dashboard">User Panel</a></li>
                    <li ><a href="{{$base_url}}login/sign_out_frontend" class='btn btn-primary btn-sm btn-login'>SIGN OUT</a></li>
                    @endif
                </ul>

            </div><!-- /.navbar-collapse -->
            </div>
        </nav>
