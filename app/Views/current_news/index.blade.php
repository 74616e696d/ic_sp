@extends('front_master.master')

@section('content')

    @include('current_news._top')
    <div class="spacer-bottom"></div>

    <div class="container">
    @include('current_news._middle')
    <div class="spacer-bottom"></div>

    <div class="spacer-bottom"></div>
    @include('current_news._bottom')
    <div class="spacer-bottom"></div>

    </div>
@stop

@section('meta_tags')

<?php
    $meta_desc='';
    $meta_key='';

     $meta_info=meta_tag_model::get_meta();
     if($meta_info)
     {
         $meta_desc=$meta_info->meta_desc;
         $meta_key=$meta_info->meta_key;
     }

?>
<meta name='description' content='{{ $meta_desc }}' />
<meta name='keyword' content='{{ $meta_key }}' />
@endsection

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/vendor/bxslider/jquery.bxslider.css">
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/css.css">
<link rel="stylesheet" href="{{$base_url}}asset/frontend/css/current_news.css">
<style>
    .bx-wrapper, .bx-viewport {
        height: 289px !important;
    }

    .footer-top .footer-social .social-facebook, .footer-top .footer-social .social-youtube, .footer-top .footer-social .social-twitter, .footer-top .footer-social .social-gplus, .footer-top .footer-social .social-linkedin {
      box-shadow: 2px 2px 2px #ccc;
      color: #fff;
      margin-right: 3px;
    }
    .list-latest{
        margin-top: 10px;
    }
    .list-latest li{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .list-latest li a{
        line-height: 20px;
        color:#444;
        text-decoration: none;
    }
    .list-latest li a:hover{
        cursor: pointer;
        color: #0177BF;
    }
</style>
@stop
@section('script')
<script type="text/javascript" src="{{$base_url}}asset/vendor/bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var title = $(document).prop('title','Current News || Iconpreparation');
    $(".bxSlider").bxSlider({
        autoHover:true,
        tiker:true,
        pager: false,
        controls:true,
    });
});
</script>
@stop