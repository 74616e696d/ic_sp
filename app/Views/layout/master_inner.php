<!DOCTYPE html>
<html>
<head>
   < <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PINNACLE TEST</title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap3.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://www.google.com/fonts#UsePlace:use/Collection:Yanone+Kaffeesatz:300"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/style-inner.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/respond.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap3.min.js"></script>
</head>
<body>
    <!-- top menu section start -->
    <div id='topmenu' class='row'>
        <nav id='top-navbar'  class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo base_url(); ?>" class="navbar-brand"><img src="<?php echo base_url(); ?>asset/img/logo.png" alt="logo"></a>
                </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li>
                    <a href="">HOME</a></li>
                    <li>
                    <a href="">ABOUT</a></li>
                    <li><a href="" class="dropdown-toggle" data-toggle='dropdown'>FREE EXAM&nbsp;&nbsp;<i class='caret'></i></a>
                        <ul class='dropdown-menu'>
                            <li><a href="">Math</a></li>
                            <li><a href="">English</a></li>
                            <li><a href="">Bangla</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <li>
                        <a href=''>Membership:Gold</a>
                    </li>
                    <li><a class='dropdown-toggle' data-toggle='dropdown' href=''>
                    <?php if($this->session->userdata('username'))echo $this->session->userdata('username');  ?>&nbsp;&nbsp;<i class='caret'></i></a>
                        <ul class='dropdown-menu'>
                            <li><a href="<?php echo base_url(); ?>member/profile"><i class='glyphicon glyphicon-user'></i>&nbsp;&nbsp;&nbsp;My Profile</a></li>
                            <li><a href=""><i class='glyphicon glyphicon-cog'></i>&nbsp;&nbsp;&nbsp;Settings</a></li>
                            <li><a href=""><i class='glyphicon glyphicon-envelope'></i>&nbsp;&nbsp;&nbsp;Inbox</a></li>
                            <li><a href="<?php echo base_url(); ?>login/sign_out"><i class='glyphicon glyphicon-off'></i>&nbsp;&nbsp;&nbsp;Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            </div>
            </nav>
    </div>
    <!-- top menu section end -->


    <!-- sitemap section start -->
    <?php $this->load->view('layout/sitemap'); ?>
    <!-- sitemap section end -->

    <!-- content section start -->
    <div class='row'>
        <div id='content' class='container'>
           <!-- left section start -->
           <?php $this->load->view('layout/left_inner'); ?>
           <!-- left section end -->

           <!-- right section start -->
            <div id='right' class="col-lg-7 col-md-7 col-sm-7">
                <?php $this->load->view($main_content, $sub_content=null); ?>
            </div>
        <!-- right section end -->
        </div>
    </div>
    <!-- content section end -->

    <!-- footer section start -->
    <div id='footer' class="row">
        <nav  class="navbar" role="navigation">
            <div class="container">
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="">HOME</a></li>
                    <li><a href="">ABOUT</a></li>
                    <li><a href="">CONTACT</a></li>
                    </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <li>
                        <a href=''>&copy;pinnacle.com <?php echo date('Y'); ?>.</a> 
                    </li>
                    <li>
                        <a href=''>All rights reserved</a>
                    </li>
                </ul>
            </div>
            </div>
            </nav>
    </div>
    <!-- footer section end -->
</body>
</html>