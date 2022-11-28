<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iconpreparation</title>
    <!-- <link href="<?php echo base_url(); ?>asset/css/bootstrap-fe.css" rel="stylesheet" type="text/css"> -->
    <!-- <link href="<?php echo base_url(); ?>asset/css/bootstrap-responsive-fe.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="{{ $base_url }}asset/member/css/bootstrap.min.css">
    <link href="{{$base_url}}asset/member/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{$base_url}}asset/css/loader.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/style.css">
    @yield('style')
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
   <!-- <script src="<?php echo base_url(); ?>asset/js/bootstrap2.min.js"></script>-->
   <script type="text/javascript" src='{{ $base_url }}asset/member/js/bootstrap.min.js'></script>
</head>
<body>

@include('member.exam.topmenu')
<!--end top nav-->

<!-- body content -->
<div class="container pad">
      <div class="row">
        @yield('content')
    </div>
</div>
<!-- </div> -->


@include('member.exam.footer_nav')

<script type="text/javascript" src="{{$base_url}}asset/js/jquery.isloading.min.js"></script>
<script type="text/javascript">
$(function(){
//Calc Object with display,clear,doCal methods
        var Calc={
            display:function(v){
                $("#display").val(v);
            },
            clear:function(){
                $("#display").val(" ");
            },
            doCal:function(val){
                var result="";
                var dtemp=$("#display").val();
                if(dtemp=="0"){
                    this.clear();
                    result=val;
                }else if(val=="c"){
                    this.clear();
                }else if(val=="="){
                    result=eval(dtemp);
                }else{
                    result=dtemp+val;
                }
                this.display(result);
            }
        }
        //Keyboard key press event.
        $("body").keypress(function(e){
            Calc.doCal(String.fromCharCode(e.which));
        });
        //calc UI click events
        $('.calc button').click(function(e){
            e.preventDefault();
            Calc.doCal(this.value);
        });
});
</script>

<script>
    $(document).ready(function()
    {
        //Handles menu drop down
        $('.dropdown-menu').find('form').click(function (e) {
            e.stopPropagation();
        });

        $('.hide-calc').click(function(){$(this).parent('div').parent('div').hide()});

        $('.exp').click(function(){
            $('#left-portion').show(2000);
        });
   
    });

</script>
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
