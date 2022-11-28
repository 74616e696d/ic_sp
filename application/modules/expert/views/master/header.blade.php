@if(!$is_auth)
<header id='home-hdr'>
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 header-title hidden-sm hidden-xs">
            <h2><strong>IMPROVE</strong> YOUR PREPARATION</h2>
            <h2>FOR <strong>BCS &amp; BANK JOB</strong></h2>
            <h2>WITH ICONPREPARATION.ORG</strong></h2>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class='login-box'>
                <form action="{{$base_url}}login/sign_in" method="post">
                    <a href="{{$base_url}}fbrequest" class="btn btn-block btn-primary btn-fb">
                    <i class="fa fa-facebook-official"></i> Login With Facebook
                    </a>
                    <p>Or</p>
                    <input type="text" name="login" id="login" required class="form-control" placeholder="Email">
                    <input type="password" name="pass" id="pass" required class="form-control password" placeholder="Password">
                    <div class="spacer"></div>
                    <button type="submit" class="btn btn-block btn-primary btn-login">
                    Login
                    </button>
                    <div class="spacer"></div>
                    <a href="{{$base_url}}login/forget_password_view" class='text-muted'>Forget my password</a>
                    <a href="{{$base_url}}public/user_reg" class='text-primary pull-right btn-new-account'>Register</a>
                </form>
            </div>
        </div>
    </div>
</header>
@endif
