@extends('front_layout.layout')

@section('banner')
@stop


@section('feature')
	@include('front_layout.watch_out')
@stop

@section('action_plan')
@include('front_layout.action_plan')
<!--   <div id="loader-wrapper">
    <div id="loader">
    </div>
</div>

<div class="overlay">
  
</div> -->
@stop


@section('style')
<link rel="stylesheet" href="<?php echo $base_url(); ?>asset/frontend/css/preloader.css">
<link rel="stylesheet" href="<?php echo $base_url(); ?>asset/css/toastr.css">
<link rel="stylesheet" href="<?php echo $base_url(); ?>asset/css/flexisel.css">
<link rel="stylesheet" href="<?php echo $base_url(); ?>asset/vendor/news-ticker/ticker-style.css">
<style>
.overlay {
  opacity:    0.9; 
  background: #0177BF;
  /*background: #fff;*/
  width:      100%;
  height:     100%; 
  z-index:    10;
  top:        0; 
  left:       0; 
  position:   fixed; 
}
.no-pad
{
    padding:0;

}
.testimonials .panel-body
{
    padding-top:15px;
}
.watch dt
{
    text-align:left;
}
.watch dd
{
    text-align:left;
}
@media only screen and (max-device-width: 480px) {
	sm-size: { font-size:12px;}
	float:left;
}

</style>
@stop

@section('script')

<script type="text/javascript" src="<?php echo $base_url(); ?>asset/vendor/news-ticker/jquery.ticker.js"></script>
<script type="text/javascript" src="{{ base_url() }}asset/frontend/js/jquery-blink.js"></script>
<script type="text/javascript" src="<?php echo $base_url(); ?>asset/member/js/jquery.cycle.all.js"></script>
<script type="text/javascript">

/*$(window).load(function(){
  $('#loader-wrapper').fadeOut();
  $('.overlay').fadeOut();
});*/

$(document).ready(function() {

	$('#cycle_opinion').cycle({fx:'scrollLeft'});

	$('#sld').cycle('fade');

  // $('a').unbind('click');
   $("#js-news").ticker({titleText: 'নোটিশ'});

    $('.mobile').blink(400);
});

</script>

    
@stop
