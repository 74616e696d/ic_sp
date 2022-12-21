<div class="row mid_news">
     
    @if($internationals)
    <?php $indx=0; ?>
    @foreach($internationals as $row)
    <?php $international_slug = $row->getSlug(); ?>
    @if($indx==0)
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
    @else
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
    @endif
        <div class="bsdo_4">
            <div class="bdr_mid">
                    <div class="row news-content">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mid_pa_height">
                                <h3><a title="" href="/news/details/{{$international_slug}}/{{$row->id}}">{{ $row->title }}</a></h3>
                                <div class=" hover01 column">
                                    <a href="/news/details/{{$international_slug}}/{{$row->id}}">
                                    <?php
                                        $img_international='/asset/news/'.$row->feature_img;
                                        if(file_exists('asset/news/small/'.$row->feature_img))
                                        {
                                            $img_international='/asset/news/small/'.$row->feature_img;
                                        }
                                    ?>
                                    <figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_international }}" class="img-responsive"></figure></a>
                                </div>
                                <?php $striped_desc_international = strip_tags($row->short_desc,'<img><a>'); ?>
                                <p><a href="/news/details/{{$international_slug}}/{{$row->id}}">
                                @if($indx==0)
                                     word_limiter($striped_desc_international, 35, '..')
                                @else
                                    word_limiter($striped_desc_international,18,'..')
                                @endif
                                </a></p>
                            </div>
                        </div>
                    <!--     <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ">
                          
                    </div> -->
                </div>
                <div class="row date_category">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                        <p>
                        <?php 
                        /* $category=current_news_category_model::get_text($row->category_id); */
                        /* $category_international=$ci->slug->create_slug($category,1); */ 
                        ?>
                        <a href="/news/categorized/{{ $row->category_id }}/{{ $category_international }}"><span class="category">{{$category}}</span></a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                        <p><span class="date"><i class="fa fa-calendar"></i>date_short($row->post_date)</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
        @if($national)
        @foreach($national as $row)
        <?php $national_slug= $row->getSlug(); ?>
        <div class="bsdo_1">
            <div class="row bdr ">
                <div class="row news-content">
                    <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="m_h">
                            <h4><a title="" href="/news/details/{{$national_slug}}/{{$row->id}}">{{ $row->title }}</a></h4>
                            <div class=" hover01 column">
                            <a href="/news/details/{{$national_slug}}/{{$row->id}}">
                            <?php
                                $img_national = '/asset/news/' . $row->feature_img;
                                if(file_exists('asset/news/small/'.$row->feature_img))
                                {
                                    $img_national = '/asset/news/small/' . $row->feature_img;
                                }
                            ?>
                            <figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_national }}" class="img-responsive "></figure></a>
                            </div>
                            <?php $striped_desc_national=strip_tags($row->short_desc,'<img><a>'); ?>
                            <p><a href="/news/details/{{$national_slug}}/{{$row->id}}">word_limiter($striped_desc_national,20,'...')</a></p>
                        </div>
                    </div>
                </div>
                <div class="row date_category">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                        <p>
                        <?php
                        $category=Current_news_category_model::get_text($row->category_id);
                        $category_national=$ci->slug->create_slug($category,1); 
?>
                        <a href="/current_news/categorized/{{ $row->category_id }}/{{ $category_national }}"><span class="category">{{ $category }}</span></a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                        <p><span class="date"><i class="fa fa-calendar"></i>date_short($row->post_date)</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        @endforeach
        @endif
    </div>
    <?php $indx++; ?>
    @endforeach
    @endif
</div>
