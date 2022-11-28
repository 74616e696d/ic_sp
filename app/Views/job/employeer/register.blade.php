<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Iconpreparation Job Circular Registration</title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="{{ $base_url }}asset/job/db/_con/images/icon.png">

  <!-- nanoScroller -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/nanoScroller/nanoscroller.css" />


  <!-- FontAwesome -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/css/font-awesome.min.css" />

  <!-- Material Design Icons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/material-design-icons/css/material-design-icons.min.css" />

  <!-- IonIcons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/ionicons/css/ionicons.min.css" />

  <!-- WeatherIcons -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/weatherIcons/css/weather-icons.min.css" />

  <!-- Google Prettify -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/google-code-prettify/prettify.css" />
  <!-- Main -->
  <link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/job/db/_con/css/_con.min.css" />
</head>

<body>

  <section id="sign-up">

    <!-- Background Bubbles -->
    <canvas id="bubble-canvas"></canvas>
    <!-- /Background Bubbles -->

    <div class="container">
        <!-- Sign Up Form -->
    <form method="POST" action="{{ $base_url }}job/employeer/save_reg">
      <div class="row links">
        <div class="col s6 logo">
          <img src="{{ $base_url }}asset/job/db/_con/images/logo.png" alt="">
        </div>
        <div class="col s6 right-align"><a href="{{ $base_url }}job/employeer/login">Sign In</a>
        </div>
      </div>

      <div style="text-align: center;">
          <?php echo $ci->session->flashdata('msg'); ?>
      </div>

      

      <div class="card-panel">



        <!-- Username -->
        <div class="input-field">
          <i class="fa fa-user prefix"></i>
          <label for="org_name">Organization Name</label>
          <input id="org_name" name="org_name" type="text">
          <span class="text-danger"><?php echo form_error('org_name'); ?></span>
        </div>
        <!-- /Username -->

        <!-- Email -->
        <div class="input-field">
          <i class="fa fa-envelope prefix"></i>
          <label for="reg_email">Email Address</label>
          <input id="reg_email" name="reg_email" type="email">
          <span class="text-danger"><?php echo form_error('reg_email'); ?></span>
        </div>
        <!-- /Email -->

        <!-- Mobile -->
        <div class="input-field">
          <i class="fa fa-mobile prefix"></i>
          <label for="org_mobile_1">Mobile Number</label>
          <input id="org_mobile_1" name="org_mobile_1" type="text">
          <span class="text-danger"><?php echo form_error('org_mobile_1'); ?></span>
        </div>
        <!-- /Mobile -->

        <!-- Password -->
        <div class="input-field">
          <i class="fa fa-unlock-alt prefix"></i>
          <label for="password">Password</label>
          <input id="password" name="password" type="password">
          <span class="text-danger"><?php echo form_error('password'); ?></span>
        </div>
        <!-- /Password -->

        <!-- Password -->
        <div class="input-field">
          <i class="fa fa-unlock-alt prefix"></i>
          <label for="rpassword">Retype Password</label>
          <input id="rpassword" name="rpassword" type="password">
          <span class="text-danger"><?php echo form_error('rpassword'); ?></span>
        </div>
        <!-- /Password -->

        <!-- <p>
          <input type="checkbox" id="checkbox_terms" />
          <label for="checkbox_terms">I agree to the <a href="#">terms of use</a>.</label>
        </p> -->

        <button name="submit" type="submit" class="waves-effect waves-light btn-large z-depth-0 z-depth-1-hover">Sign Up</button>
      </div>
   </form>
    
    <!-- /Sign Up Form -->

    </div>

  </section>

  <!-- jQuery -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/jquery/jquery.min.js"></script>
  <!-- DEMO [REMOVE IT ON PRODUCTION] -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


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


  <!-- Google Prettify -->
  <script type="text/javascript" src="{{ $base_url }}asset/job/db/google-code-prettify/prettify.js"></script>
</body>
</html>