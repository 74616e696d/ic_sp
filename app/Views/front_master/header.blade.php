@guest
<header id='home-hdr'>

	<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1687575671460411');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1687575671460411&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 header-title hidden-sm hidden-xs">
            <h1><strong>IMPROVE</strong> YOUR PREPARATION</h1>
            <h2>FOR <strong>BCS &amp; BANK JOB</strong></h2>
            <h2>WITH ICONPREPARATION.COM</strong></h2>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class='login-box'>
                <form action="/login" method="POST">
                    <?php 
                    if(isset($errors))
                    {
                        if(is_array($errors) && !empty($errors))
                        {
                            ?>
                            <div class="alert alert-danger">
                            <?php
                            foreach($errors AS $error)
                            {
                                echo $error . '<br/>';
                            }
                            ?>
                            </div>
                    <?php
                        }
                    }
                    
                    ?>
                    <input type="text" name="email" id="login" required class="form-control" placeholder="Email">
                    <input type="password" name="password" id="pass" required class="form-control password" placeholder="Password">
                    <div class="spacer"></div>
                    <button type="submit" class="btn btn-block btn-primary btn-login">
                    Login
                    </button>
                    <div class="spacer"></div>
                    <a href="/login/forget_password_view" class='text-muted' title="Forget Password">Forget my password</a>
                    <a href="/public/user_reg" class='text-primary pull-right btn-new-account' title="signup now">Signup Now</a>
                </form>
            </div>
        </div>
    </div>
</header>
@endguest
