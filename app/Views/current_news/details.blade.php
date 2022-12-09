@extends('front_master.master')


@section('meta_tags')
<?php
    $meta_desc='';
    $meta_key='';
    // $meta_info=meta_tag_model::get_meta();
    // if($meta_info)
    // {
    //     $meta_desc=$meta_info->meta_desc;
    //     $meta_key=$meta_info->meta_key;
    // }
?>
<meta name='description' content='{{ $meta_desc }}' />
<meta name='keyword' content='{{ $meta_key }}' />
@endsection

@section('content')
<div class="container-fluid-content">
    <div class="container">
        <div class="row auto_mar">

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 white_background">
                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 c_d_c">
                    <?php 
                    $category = $news->category();
                    $category_slug = $category->name;  
                    ?>
                    <h4><a href="{{ $base_url }}news/categorized/{{ $news->category_id }}/{{ $category_slug }}">{{ $category->name }}</a></h4>
                    </div>
                </div>

                <div class="spacer-bottom"></div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img style="margin:0 auto;" src="{{ $base_url }}asset/news/{{ $news->feature_img }}" class="img-responsive" alt="{{ $news->title }}">
                    </div>
                </div>

                <div class="spacer-bottom"></div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4><a href="#">{{ $news->title }}</a></h4>
                    </div>
                </div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>date_short($news->post_date) }}</p>
                    </div>
                </div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 details-content">
                       <?php $details=strip_tags($news->details,'<br/><br><img><a><p><sub><sup><i><b><strong><li><ul><table><thead><tbody><tr><th><td>'); ?>
                       {{ $details }}
                    </div>
                </div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id='social'>
                            
                        </div>
                        <?php
                        $fb_url=current_url();
                        $title=!empty($news->title)?$news->title:'Iconpreparation';
                        $summery=word_limiter(strip_tags($details),70);
                        ?>
                    </div>
                </div>

                 <!-- <div class="spacer-bottom-with-back"></div>

                 <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
                        <img src="{{ $base_url }}asset/frontend/img/ad11.jpg" class="img-responsive" alt="Adv">
                    </div>
                 </div> -->

                <div class="spacer-bottom-with-back"></div>
                

                <div class="row auto_mar">
                    <!-- START NEWS WITH SAME TAGS -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <ul class="list-group cat-list">
                            <li class='list-group-item active'>আরও পড়ুন</li>
                            @if($tags_news)
                            @foreach($tags_news as $row)
                            <?php 
                            $tags_slug=$ci->slug->create_slug($row->title,1);  
                            ?>
                            <li class="list-group-item"><a href="{{ $base_url }}news/details/{{ $tags_slug }}/{{ $row->id }}">
                            <span class='list-circle'></span>{{ $row->title }}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- END NEWS WITH SAME TAGS -->
                    
                    <!-- START LATEST NEWS -->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <ul class="list-group cat-list">
                            <li class='list-group-item active'>সর্বশেষ</li>
                            @if($top_news)
                            @foreach($top_news as $row)
                            <?php 
                            $news_slug=$ci->slug->create_slug($row->title,1);  
                            ?>
                            <li class="list-group-item"><a href="{{ $base_url }}news/details/{{ $news_slug }}/{{ $row->id }}">
                            <span class='list-circle'></span>{{ $row->title }}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- END LATEST NEWS -->

                    <div class="spacer-bottom-with-back"></div>
                </div>
                @include('forum.footer')
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3 style="padding-left: 0;">Comment with facebook</h3>
                    <?php 
                    $news_slug= $news->getSlug();
                    ?>
                    <div class="fb-comments" data-href="{{$base_url}}news/details/{{ $news_slug }}/{{$news->id}}" data-numposts="10"></div>
                </div>
            </div>

            <!-- START RIGHT SIDE -->
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="http://discounts.com.bd/" target="_blank"><img src="{{ $base_url }}asset/frontend/img/add10.jpg" class="img-responsive" alt="Discount Shop Bangladesh"> 
                        </a>
                    </div>
                </div>

                <div class="spacer-bottom"></div>

                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="list-group cat-list">
                            <li class='list-group-item active'>এই বিভাগের অন্যান্য খবর</li>
                            @if($category_news)
                            @foreach($category_news as $row)
                            <?php 
                            $title_slug=$ci->slug->create_slug($row->title,1);  
                            ?>
                            <li class="list-group-item"><a href="{{ $base_url }}news/details/{{ $title_slug }}/{{ $row->id }}">
                            <span class='list-circle'></span>{{ $row->title }}</a></li>
                            @endforeach
                            <li class="list-group-item"><a href='{{ $base_url }}news/categorized/{{ $news->category_id }}/{{ $category_slug }}'>সব নিউজ পড়ুন ...</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                   <div class="spacer-bottom"></div>

            <div class="row auto_mar">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="http://revinr.com/" target='_blank'>
                    <img src="{{ $base_url }}asset/frontend/img/ad12.png" class="img-responsive" alt="#"></a>
                </div>
            </div>
            <div class="spacer-bottom"></div>
            <div class="row auto_mar twt">
                <h4>Recent Tweets</h4>
                <a class="twitter-timeline"  href="https://twitter.com/search?q=Iconpreparation" data-chrome="noheader nofooter" height='400' data-widget-id="755631558141341697">Tweets by Iconpreparation</a>
            </div>
            <div class="spacer-bottom"></div>

            @if($is_admin)
            <div class="row auto_mar">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <a id='btnInvite' href="{{ get_referral_url() }}" data-title='Register &amp; Get One Week Full Access' data-desc='Hi There' data-image='{{ $base_url }}asset/frontend/new/img/logo.png' class='btn btn-default btn-block'>Invite Your Friends</a>
                </div>
            </div>
            @endif

            </div>
            <!-- END RIGHT SIDE -->
            
        </div>
    </div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/jssocials/jssocials.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/jssocials/jssocials-theme-flat.css">
<link rel="stylesheet" href="{{$base_url}}asset/frontend/css/current_news.css">
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/feature.css">
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/current_news_flipcard.css">
<style>
    .c_d_c{
        background: #fff;
    }
    .c_d_c h4 a {
        color: #ff0000 !important;
        }
        html, body{
        font-size:13px;
        color:#333;
        }
        .top_news{
            padding-top: 20px;
        }
        .bx-wrapper, .bx-viewport {
          height: 206px !important;
        }
     /*   .footer-top .footer-social .social-facebook, .footer-top .footer-social .social-youtube, .footer-top .footer-social .social-twitter, .footer-top .footer-social .social-gplus, .footer-top .footer-social .social-linkedin {
          box-shadow: 2px 2px 2px #ccc;
          color: #fff;
          margin-right: 3px;
        }*/

    .twt {
      width: 92%;
      background: #fff;
    }
    .media-list {
      padding-left: 0;
      list-style: none;
      margin-left: 15px;
    }

    .media-left,
    .media > .pull-left {
      padding-right: 10px;
    }
    .media-left,
    .media-right,
    .media-body {
      display: table-cell;
      vertical-align: top;
    }
    .media,
    .media-body {
      overflow: hidden;
      zoom: 1;
    }
    .media-body {
      width: 10000px;
    }
    .media-body a,.media-body span{
        display: block;
        font-style:italic;
    }
    .media-object {
      display: block;
    }
    .media-object.img-thumbnail {
      max-width: none;
    }
    .flip{
        margin-left:0 !important;
        margin-right:0 !important;
        margin-top: -4px !important;
    }
    .flip-card{
        padding:0;
     
    }
</style>

@stop
@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/jssocials/jssocials.min.js"></script>
 <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
 <script type="text/javascript" src="{{ $base_url }}asset/vendor/flip/jquery.flip.min.js"></script>
<script type="text/javascript">
$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
$(document).bind('keydown', 'ctrl+u', function(){$('#save').click(); return false;});
 $(document).bind("contextmenu",function(e){
        return false;
 }); 
$(document).ready(function() {

    $(".flip-card").flip({
      trigger: 'hover',
      reverse: true
    });

    $("#social").jsSocials({
        showLabel: false,
        showCount: false,

        shares: [{
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.text = "(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));";
                $result.append(script);

                $("<div>").addClass("fb-share-button")
                    .attr("data-layout", "button_count")
                    .appendTo($result);

                return $result;
            }
        }, {
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.src = "https://apis.google.com/js/platform.js";
                $result.append(script);

                $("<div>").addClass("g-plus")
                    .attr({
                        "data-action": "share",
                        "data-annotation": "bubble"
                    })
                    .appendTo($result);

                return $result;
            }
        },
        {
            renderer: function() {
                var $result = $("<div>");

                var script = document.createElement("script");
                script.text = "window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));";
                $result.append(script);

                $("<a>").addClass("twitter-share-button")
                    .text("Tweet")
                    .attr("href", "https://twitter.com/share")
                    .appendTo($result);

                return $result;
            }
        }]
    });


    $('#btnInvite').click(function(e){
        e.preventDefault();
        var elem = $(this);
        postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

        return false;
    });

    function postToFeed(title, desc, url, image) 
    {
        var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
        function callback(response) {}
        FB.ui(obj, callback);
    }

});
 
</script>
@stop

@section('fbmeta')
<?php
$current_url=current_url();
$current_url=str_replace('index.php/', '', $current_url);
?>
<meta property="og:url" content="{{ $current_url }}" />
<meta property="og:type" content="article" />
<meta property="og:description" content="{{ strip_tags($details) }}" />
<meta property="og:image" content="{{ $base_url }}asset/news/{{ $news->feature_img }}" />
@stop
