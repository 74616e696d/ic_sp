<?php
use App\Helpers\text_helper;
use App\Models\Current_news_category_model;
$currentNewsCategoryModel = new Current_news_category_model();
$slug = new App\Libraries\Slug;

?>
<div class="container">
    <div class="row  p_r">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="row p_r">

                <!-- START FEATURED NEWS -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="bsdo">
                       
                    @if(isset($featured) && $featured)
                    @foreach($featured as $row)
                    <?php $feature_slug=$slug->create_slug($row->title,1);
                    ?>
                   
                        <div class="row p_r">
                            <div class="hover01 column   bdr_green">
                                <a href="{{base_url()}}news/details/{{$feature_slug}}/{{$row->id}}">
                                <figure>
                                <img alt="{{ $row->title }}" src="{{ base_url() }}/public/asset/news/{{ $row->feature_img }}" class="img-responsive"></figure>
                                </a>
                            </div>
                            <div class="pa_height" style="min-height: 275px;">
                                <h2><a title="" href="{{base_url()}}news/details/{{$feature_slug}}/{{$row->id}}">{{ $row->title }}</a></h2>
                                <?php $striped_desc_feature=strip_tags($row->details,'<img><a>'); ?>
                                <p>
                                <a href="{{ base_url() }}news/details/{{$feature_slug}}/{{$row->id}}">
                                <?php echo word_limiter($striped_desc_feature,50,'...'); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="row date_category ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c1">
                                <p>
                                <?php 
                                $category=$currentNewsCategoryModel->get_text($row->category_id);
                                $category_featured=$slug->create_slug($category,1); 
                                ?> 
                                <a href="{{ base_url() }}news/categorized/{{ $row->category_id }}/{{ $category_featured }}">
                                <span class="category">{{$category}}</span></a>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                                <p><span class="date"><i class="fa fa-calendar"></i><?php echo date_short($row->post_date); ?></span></p>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    </div>
                    <!-- Display Latest News -->
                    @if(isset($latest) && $latest)
                    <div class="bsdo">
                        <ul class="list-unstyled list-latest">
                            @foreach($latest as $row)
                            <li>
                                <?php
                                $latest_slug=$slug->create_slug($row->title);
                                ?>
                                <a href="{{ base_url() }}news/details/{{ $latest_slug }}/{{ $row->id }}">{{ $row->title }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="bddo" style='padding-top:10px;'>
                        <h4>Get Our Apps On Playstore</h4>
                        <a href='https://play.google.com/store/apps/details?id=com.Iconpreparation.modeltest' target='_blank'>
                        <img src="{{ base_url() }}/public/asset/frontend/new/img/android.png" alt="Current World App">
                        </a>
                    </div>
                    <!-- End display latest news -->
                </div>
                <!-- END FEATURED NEWS -->

                <!-- START NATIONAL NEWS -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <h3 class="on-this-day-title" style="padding: 0px;margin-top: 25px;margin-bottom: 20px;font-weight: 600;font-size: 28px">গুরুত্বপূর্ণ</h3>
                    </div>
                    @if(isset($important) && $important)
                    <div class="bsdo">
                        <ul class="list-unstyled list-latest">
                            @foreach($important as $row)
                            <li>
                                <?php
                                $imp_slug=$slug->create_slug($row['title']);
                                ?>
                                <a href="{{ base_url() }}news/details/{{ $imp_slug }}/{{ $row['id'] }}">{{ $row['title'] }}</a>
                            </li>
                            <span style="border: 1px solid #eee;display: block;margin: 5px 0px;"></span>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5%">
                        <a href="{{ base_url() }}current_news/important_news/" class="btn btn-block btn-primary">View All</a>
                    </div>
                    @endif
                </div>
                <!-- END NATIONAL NEWS -->
            </div>
        </div>
      
<!-- start right column -->
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
<div class="">
    <div class="row on_this-day bsdo_3 no-pad-left">
        <div class="bx-wrapper" style="max-width: 100%; margin: 0px auto;">
            <div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 216px;">
                <div class="bxSlider" style="width: 515%; position: relative; transition-duration: 0s; transform: translate3d(-385px, 0px, 0px);">
                    @if(isset($on_this_day) && $on_this_day)
                    @foreach($on_this_day as $row)
                    <div style="float: left; list-style: outside none none; position: relative; width: 385px;" class="bx-clone">
                  <!--       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-pad-left">
                      
                  </div> -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="s_m_h">
                                <h3 class="on-this-day-title">আজকের দিনে</h3>
                                <?php 
                                $dtls=strip_tags($row->details);
                                $dtls=preg_replace('/\s+/', ' ', $dtls);
                                 ?>
                                <p style='padding-left:0 !important;' class='on-this-day-content'>
                                <img  alt="{{ $row->title }}" src="{{ base_url() }}/public/asset/news/{{ $row->photo }}" class="img-responsive">
                                {{ $dtls }}
                                </p>
                            </div>
                            <p style='padding-left:0;'>
                                <span class="date">
                                <i class="fa fa-calendar"></i>
                                <?php echo date('F d',strtotime($row->happening_date)); ?>
                                </span>
                            </p>

                        </div>
                    </div>
                   
                    @endforeach
                    @endif
                      
                </div>
            </div>
            <!-- <div class="bx-controls bx-has-controls-direction">
                <div class="bx-controls-direction"><a href="" class="bx-prev">Prev</a><a href="" class="bx-next">Next</a></div>
            </div> -->
        </div>
    </div>
</div>
    
<div class="spacer-bottom"></div>
<div class="row add">
    <!-- G&R_320x50 -->
    <script id="GNR34723">
        (function (i,g,b,d,c) {
            i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
            var s=d.createElement(b);s.async=true;s.src=c;
            var x=d.getElementsByTagName(b)[0];
            x.parentNode.insertBefore(s, x);
        })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
        gandrad({siteid:11464,slot:34723});
    </script>
    <!-- End of G&R_320x50 -->
    
  <!--   <img width="100%" alt="" class="img-responsive" src="{{ base_url() }}asset/frontend/img/add2.gif"> -->
    <br>
</div>
</div>
<!-- end right column -->
</div>
</div>