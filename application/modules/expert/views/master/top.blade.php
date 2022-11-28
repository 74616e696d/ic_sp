<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="{{ $base_url }}expert/dashboard">Expert Zone</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
       
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                        <p class="notification">5</p>
              <p>Notifications</p>
              <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Notification 1</a></li>
                    <li><a href="#">Notification 2</a></li>
                  </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                <p>Welcome {{ $username }}</p>
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ $base_url }}expert/profile"><i class="fa fa-cog"></i> Profile Settings</a></li>
                  <li><a href="{{ $base_url }}expert/login/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </li>
            </ul>

        </div>
    </div>
</nav>