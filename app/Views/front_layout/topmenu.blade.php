<header class="main bg-dark home-3">
    <div class="container">
        <nav class="navbar" role="navigation">
            <div class="navbar-header">
                @auth
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @endauth

                <a class="navbar-brand" href="{{$base_url}}">
                <img id="logo" src="{{$base_url}}asset/frontend/img/logo.png" alt="Iconpreparation" />
                </a>

                <!-- &nbsp;&nbsp;&nbsp;<a href=""><i class="fa fa-phone"></i>&nbsp;01994333333</a> -->
            </div>
            <div class="collapse navbar-collapse">
            <div class="navbar-right menu-main"> 
                <ul class="nav navbar-nav">
                  
                    <!-- <li class="active"><a href="{{$base_url}}"><span>হোম</span></a></li>-->
                    <!-- <li><a href="{{$base_url}}font_help"><span><img src="{{$base_url}}asset/frontend/img/font.png" alt="Font"></span></a></li>  -->
                    @auth
                    <li><a class='user-profile' href="{{$base_url}}member/dashboard"><span>ইউজার প্যানেল</span></a></li>
                    @endauth
                </ul>

                <?php //$authenticated=$this->session->userdata('userid')?true:false; ?>
                @guest
                <!-- <div class="btn-group">

                  <a class='dropdown-toggle sign-in' href="{{$base_url}}public/user_reg">রেজিস্ট্রেশন</a>
                <a class="dropdown-toggle sign-in" data-toggle="dropdown">লগ ইন</a>
                  <div class="dropdown-menu login" >
                  <div class='row no-margin'>
                  <form action="{{$base_url}}login/sign_in" method="post">
                        <div class="col-sm-12">
                            <h5><strong>লগ ইন</strong> অথবা <span><a id='lnk_sign_up' href="{{$base_url}}public/user_reg"><i><strong>এখনই সাইন আপ করুন</strong></i></a></span></h5>
                            <div class="row">
                                <div class='col-xs-12 col-sm-12 col-md-12'>
                                    <a href="{{$base_url}}index/fb_request" class="btn btn-xs btn-primary btn-block"><i class="fa fa-facebook"></i>Facebook</a>
                                </div>
                            </div>
                          <div class="login-or">
                                <hr class="hr-or">
                                <span class="span-or">অথবা</span>
                           </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <input type="text" name="login" placeholder="ইমেইল অথবা নাম" class="form-control input-sm" id="inputError" />
                            </div>
                            <br/>
                            <div class="col-sm-12">
                                <input type="password" name="pass" placeholder="পাসওয়ার্ড" class="form-control input-sm" name="password" id="Password1" />
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-md">
                                <i class="fa fa-check"></i>লগ ইন</button>
                                <a style="margin-top:5px;" class='forget-pass' href="{{$base_url}}login/forget_password_view">পাসওয়ার্ড ভুলে গেছেন<i class="fa fa-question"></i></a>
                            </div>
                        </div>
                    </form>
                    </div>
                    </div>
                </div> -->

                <!-- <a class="btn btn-theme navbar-btn btn-orange  sign-up" href="{{$base_url}}public/user_reg">Sign up</a> -->
                @endguest
                @auth
                <div class="btn-group">
                    <a class="sign-up" href="/login/sign_out_frontend">সাইন আউট</a>
                </div>
                @endauth
            </div>
            </div>
        </nav>
    </div>
</header>