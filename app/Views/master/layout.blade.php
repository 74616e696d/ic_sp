<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Iconpreparation  | @if(isset($title)){{$title}}@endif</title>
        <link rel="shortcut icon" href="{{$base_url}}/asset/frontend/img/favicon.ico" type="image/x-icon">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{$base_url}}/asset/member/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{$base_url}}/asset/member/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{$base_url}}/asset/member/css/ionicons.min.css" rel="stylesheet" type="text/css" />
      
        <!-- Theme style -->
        <link href="{{$base_url}}/asset/member/css/AdminLTE.css" rel="stylesheet" type="text/css" /> 

        <link rel="stylesheet" href="{{$base_url}}/asset/member/css/common.css">
        
        <style>

        .collapse
        {
            border-bottom:1px solid #ccc;
        }
        #rpt-menu{}
        #rpt-menu li
        {
            line-height:35px !important;
            list-style:none;
            border-bottom:1px solid #ccc;
        }
        #rpt-menu li a
        {
            padding:12px 5px 12px 15px;
        }
        .content{
            min-height: 700px;
        }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//v2.zopim.com/?2RQ4iV0FsLNwkgMO5M9MW1lDR43YFUaD';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!--End of Zopim Live Chat Script-->

        @yield('style')
    </head>
    <body class="skin-blue">
    <div id="fb-root"></div>
      <script>
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1110518105654669";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
        <!-- header logo: style can be found in header.less -->
        @include('master.header')
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
           @include('master.left')

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
               @include('master.content_header')

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                           
                        </div>
                    </div>  
                    @yield('content')
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

        @include('master.footer')


<!-- jQuery 2.0.2 -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
<script type="text/javascript" src="{{$base_url}}/asset/member/js/jquery-1.10.2.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="{{$base_url}}/asset/member/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{$base_url}}/asset/member/js/bootstrap.min.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="{{$base_url}}/asset/member/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>  
<!-- AdminLTE App -->
<script src="{{$base_url}}/asset/member/js/AdminLTE/app.js" type="text/javascript"></script>

<script type="text/javascript" src="{{$base_url}}/js/custom/general.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var curr_uri='{{current_url()}}',
        curr_uri_plain=curr_uri.replace('/index.php','');
        lists=$('ul.sidebar-menu>li');
        $('ul.sidebar-menu>li').removeAttr('class');
        $.each(lists,function(){
            var url=$(this).children('a').attr('href');
            if(url==curr_uri_plain)
            {
                $(this).attr('class','active');
            }

        });
    });
</script>
        <script type="text/javascript" src="{{$base_url}}asset/member/js/custom.js"></script>

        @yield('script')

        <script>
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

         ga('create', 'UA-55677449-1', 'auto');
         ga('send', 'pageview');

        </script>
    
    </body>
</html>
