<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Iconpreparation Job Circular Login</title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
  <link rel="icon" type="image/png" href="{{ $base_url }}asset/job/db/_con/images/icon.png">

  <!-- nanoScroller -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/nanoScroller/nanoscroller.css" />


  <!-- FontAwesome -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/font-awesome/css/font-awesome.min.css" />

  <!-- Material Design Icons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/material-design-icons/css/material-design-icons.min.css" />

  <!-- IonIcons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/ionicons/css/ionicons.min.css" />

  <!-- WeatherIcons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/weatherIcons/css/weather-icons.min.css" />
  <!-- Main -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/_con/css/_con.min.css" />
</head>

<body>

  <section id="sign-in">

    <!-- Background Bubbles -->
    <canvas id="bubble-canvas"></canvas>
    <!-- /Background Bubbles -->

    <div class="container">
        <!-- Sign In Form -->
    <?php echo form_open('job/employeer/user_login_check'); ?>
      <div class="row links">
        <div class="col s6 logo">
          <img src="{{ $base_url }}asset/job/db/_con/images/logo.png" class="img-responsive"alt="">
        </div>
        <div class="col s6 right-align"><a href="{{ $base_url }}job/employeer/register">Sign Up</a>
        </div>
      </div>

      <div class="card-panel">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12" >
            <?php 
            if (validation_errors()) {
              ?>
              <div class="alert" style="text-align: center;">
                <?php echo validation_errors(); ?>
              </div>
              <?php
            }

            if (isset($error_login)): 
             ?>
              <div class="alert" style="text-align: center;">
                <?php echo $error_login ?>
              </div>

            <?php endif; ?>
          </div>
        </div>

        <!-- Username -->
        <div class="input-field">
          <i class="fa fa-envelope prefix prefix"></i>
          <input id="reg_email" name="reg_email" type="text" class="validate" required>
          <label for="reg_email">Email Address</label>
        </div>
        <!-- /Username -->

        <!-- Password -->
        <div class="input-field">
          <i class="fa fa-unlock-alt prefix"></i>
          <input id="password" name="password" type="password" class="validate" required>
          <label for="password">Password</label>
        </div>

        <button type="submit" value="Submit" class="waves-effect waves-light btn-large z-depth-0 z-depth-1-hover">Sign In</button>
      </div>

      <div class="links right-align">
        <a href="#">Forgot Password?</a>
      </div>

    <?php echo form_close(); ?>
    <!-- /Sign In Form -->

    </div>

  </section>


  <!-- DEMO [REMOVE IT ON PRODUCTION] -->
<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/_con/js/_demo.js"></script>

  <!-- jQuery -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/jquery/jquery.min.js"></script>

  <!-- jQuery RAF (improved animation performance) -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/jqueryRAF/jquery.requestAnimationFrame.min.js"></script>

  <!-- nanoScroller -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/nanoScroller/jquery.nanoscroller.min.js"></script>

  <!-- Materialize -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/materialize/js/materialize.min.js"></script>

  <!-- Sortable -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/sortable/Sortable.min.js"></script>

  <!-- Main -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/_con/js/_con.min.js"></script>

</body>


<!-- Mirrored from nkdev.info/con/page-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 18 Apr 2015 12:58:44 GMT -->
</html>