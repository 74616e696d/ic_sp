@extends('current_news.master.master')
@section('content')
<div class="container-fluid-content">
    <div class="container">
        <div class="row auto_mar">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 c_d_c">
                        <h4><a href="">{{ strtoupper($cat_name) }}</a></h4>
                    </div>
                </div>
                <div class="spacer-bottom"></div>
                <div class="for_background">
                    @if($news)
                    <?php $indx=0; ?>
                    @foreach($news as $row)
                    <?php $slug=$ci->slug->create_slug($row->title,1); ?>
                    <div class="row auto_mar for_border">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?php
                                $img_cat=$base_url.'asset/news/'.$row->feature_img;
                                if(file_exists('asset/news/square/'.$row->feature_img))
                                {
                                    $img_cat=$base_url.'asset/news/square/'.$row->feature_img;
                                }
                            ?>
                            <img src="{{ $img_cat }}" class="img-responsive" alt="{{ $row->title }}">

                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-pad-left">
                            <h4><a title="" href="{{$base_url}}news/details/{{$slug}}/{{$row->id}}">{{ $row->title }}</a></h4>

                      

                            <p class="n_c_date">{{ date_short($row->post_date) }}</p>
                            <?php $striped_desc=strip_tags($row->short_desc,'<img><a>'); ?>
                            <p class='category-details'><a href="{{$base_url}}news/details/{{$slug}}/{{$row->id}}">{{ $striped_desc }}</a></p>
                            <p class="go_right">
                            <a href="{{$base_url}}news/details/{{$slug}}/{{$row->id}}">Details</a>
                            </p>
                        </div>
                        @if($indx==1)
                        {{-- <div class="spacer-bottom"></div>
                        <div class="row auto_mar">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad-left no-pad-right">
                                <img src="{{ $base_url }}asset/frontend/img/ad11.jpg" class="img-responsive" alt="#">
                            </div>
                        </div> --}}
                        <div class="spacer-bottom"></div>
                        @endif
                    </div>
                    <?php $indx++; ?>
                    @endforeach
                    <nav style='padding-left:10px;'>
                        {{ $page_link }}
                    </nav>
                    @endif

                </div>
            </div>
            <div class="col-lg-4  no-pad-right">
                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad-right">
                        <img src="{{ $base_url }}asset/frontend/img/add10.jpg" class="img-responsive" alt="#">
                    </div>
                </div>
                <div class="spacer-bottom"></div>
                <div class="row auto_mar">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad-right">
                      
                            <ul class="list-group cat-list">
                                <li class='list-group-item active'>OTHER CATEGORIES</li>
                                @if($categories)
                                @foreach($categories as $row)
                                <?php 
                                $category_slug=$ci->slug->create_slug($row->name,1);  
                                ?>
                                <li class="list-group-item"><a href="{{ $base_url }}news/categorized/{{ $row->id }}/{{ $category_slug }}">
                                <span class='list-circle'></span>{{ $row->name }}</a></li>
                                @endforeach
                                @endif
                            </ul>
                    </div>
                </div>
                <!-- <div class="spacer-bottom"></div> -->
                <div class="row auto_mar" style="margin-bottom:15px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad-right">
                        <img src="{{ $base_url }}asset/frontend/img/ad12.jpg" class="img-responsive" alt="#">
                    </div>
                </div>

            </div>
        </div>
    </div>
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
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/css.css">
<link rel="stylesheet" href="{{$base_url}}asset/frontend/css/current_news.css">
<style>
.footer-top .footer-social .social-facebook, .footer-top .footer-social .social-youtube, .footer-top .footer-social .social-twitter, .footer-top .footer-social .social-gplus, .footer-top .footer-social .social-linkedin {
  box-shadow: 2px 2px 2px #ccc;
  color: #fff;
  margin-right: 3px;
}
</style>
@stop