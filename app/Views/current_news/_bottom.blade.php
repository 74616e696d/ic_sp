<div class="row">
      
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
            <!-- STARTS SPORTS -->
            @if(isset($sports) && $sports)
            @foreach($sports as $row)
            <?php $sports_slug=$ci->slug->create_slug($row->title,1); ?>
                <div class="row ">
                    <div class="bsdo_8">
                        <div class="bdr">
                            <div class="row">
                                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="m_h">
                                        <h4><a title="" href="{{$base_url}}news/details/{{$sports_slug}}/{{$row->id}}">{{ $row->title }}</a></h4>
                                        <div class=" hover01 column">
                                        <?php
                                            $img_sports=$base_url.'asset/news/'.$row->feature_img;
                                            if(file_exists('asset/news/'.$row->feature_img))
                                            {
                                                $img_sports=$base_url.'asset/news/'.$row->feature_img;
                                            }
                                        ?>
                                        <a href="{{$base_url}}news/details/{{$sports_slug}}/{{$row->id}}"><figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_sports }}" class="img-responsive "></figure></a>
                                        </div>
                                        <?php $striped_desc_sports=strip_tags($row->short_desc,'<img><a>'); ?>
                                        <p><a href="{{$base_url}}news/details/{{$sports_slug}}/{{$row->id}}">{{ word_limiter($striped_desc_sports,35,'...') }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row date_category">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                                    <p>
                                    <?php 
                                    $category=current_news_category_model::get_text($row->category_id);
                                    $category_sports=$ci->slug->create_slug($category,1); 
                                    ?>
                                    <a href="{{ $base_url }}news/categorized/{{ $row->category_id }}/{{ $category_sports }}"><span class="category">{{$category}}</span></a>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                                    <p><span class="date"><i class="fa fa-calendar"></i>{{ date_short($row->post_date) }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer"></div>
            @endforeach
            @endif
          <!--  END SPORTS -->

            <!-- START AWARDS -->
            @if(isset($awards) && $awards)
            @foreach($awards as $row)
            <?php $awards_slug=$ci->slug->create_slug($row->title,1); ?>
                <div class="row ">
                    <div class="bsdo_8">
                        <div class="bdr">
                            <div class="row news-content">
                                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="m_h">
                                        <h4><a title="" href="{{$base_url}}news/details/{{$awards_slug}}/{{$row->id}}">{{ $row->title }}</a></h4>
                                        <div class=" hover01 column">
                                        <?php
                                            $img_awards=$base_url.'asset/news/'.$row->feature_img;
                                            if(file_exists('asset/news/'.$row->feature_img))
                                            {
                                                $img_awards=$base_url.'asset/news/'.$row->feature_img;
                                            }
                                        ?>
                                        <a href="{{$base_url}}news/details/{{$awards_slug}}/{{$row->id}}"><figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_awards }}" class="img-responsive "></figure></a>
                                        </div>
                                        <?php $striped_desc_awards=strip_tags($row->short_desc,'<img><a>'); ?>
                                        <p><a href="{{$base_url}}news/details/{{$awards_slug}}/{{$row->id}}">{{ word_limiter($striped_desc_awards,35,'...') }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row date_category">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                                    <p>
                                    <?php 
                                    $category=current_news_category_model::get_text($row->category_id);
                                    $category_awards=$ci->slug->create_slug($category,1); 
                                    ?>
                                    <a href="{{ $base_url }}news/categorized/{{ $row->category_id }}/{{ $category_awards }}"><span class="category">{{$category}}</span></a>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                                    <p><span class="date">
                                    <i class="fa fa-calendar"></i>{{ date_short($row->post_date) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer"></div>
            @endforeach
            @endif
            <!-- END AWARDS -->
        </div>

        <!-- START BUSINESS -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 space ">
            <div class="bsdo_10">
                <div class="bdr">
                @if(isset($business) && $business)
                @foreach($business as $row)
                <?php $business_slug=$ci->slug->create_slug($row->title,1); ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="pa_la_height">
                                <h4><a title="" href="{{$base_url}}news/details/{{$business_slug}}/{{$row->id}}">
                                {{ $row->title }}
                                </a></h4>
                                <div class="b_s hover01 column">
                                    <a href="{{$base_url}}news/details/{{$business_slug}}/{{$row->id}}">
                                    <figure>
                                    <img alt="{{ $row->title }}" src="{{ $base_url }}asset/news/{{ $row->feature_img }}" class="img-responsive" style="max-height:250px">
                                    </figure>
                                    </a>
                                </div>
                                <?php $striped_desc_business=strip_tags($row->details,'<img><a>'); ?>
                                <p><a href="{{$base_url}}news/details/{{$business_slug}}/{{$row->id}}">
                                {{ word_limiter($striped_desc_business,35,'..') }}
                                </a></p>
                            </div>
                        </div>
                    </div>
                    <div class="row date_category">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                            <p>
                            <?php 
                            $category=current_news_category_model::get_text($row->category_id);
                            $category_business=$ci->slug->create_slug($category,1); 
                            ?>
                            <a href="{{ $base_url }}news/categorized/{{ $row->category_id }}/{{ $category_business }}"><span class="category">{{ $category }}</span></a>
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                            <p><span class="date"><i class="fa fa-calendar"></i>{{ date_short($row->post_date) }}</span></p>
                        </div>
                    </div>
                @endforeach
                @endif
                </div>
            </div>
        </div>
        <!-- END BUSINESS -->

    
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">

        <!-- START SCIENCE -->
        @if(isset($science) && $science)
        @foreach($science as $row)
         <?php $science_slug=$ci->slug->create_slug($row->title,1); ?>
            <div class="row ">
                <div class="bsdo_11">
                    <div class="bdr">
                        <div class="row news-content">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="m_h">
                                    <h4><a title="" href="{{$base_url}}news/details/{{$science_slug}}/{{$row->id}}">{{ $row->title }}</a></h4>
                                    <div class=" hover01 column">
                                    <?php
                                        $img_science=$base_url.'asset/news/'.$row->feature_img;
                                        if(file_exists('asset/news/small/'.$row->feature_img))
                                        {
                                            $img_science=$base_url.'asset/news/small/'.$row->feature_img;
                                        }
                                    ?>
                                    <a href="{{$base_url}}news/details/{{$science_slug}}/{{$row->id}}"><figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_science }}" class="img-responsive "></figure></a>
                                    </div>
                                    <?php $striped_desc_science=strip_tags($row->short_desc,'<img><a>'); ?>
                                    <p><a href="{{$base_url}}news/details/{{$science_slug}}/{{$row->id}}">{{ word_limiter($striped_desc_science,35,'..') }}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="row date_category">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 c">
                                <p>
                                <?php 
                                $category=current_news_category_model::get_text($row->category_id);
                                $category_science=$ci->slug->create_slug($category,1); 
                                ?>
                                <a href="{{ $base_url }}news/categorized/{{ $row->category_id }}/{{ $category_science }}"><span class="category">{{current_news_category_model::get_text($row->category_id)}}</span></a>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d">
                                <p><span class="date"><i class="fa fa-calendar"></i>{{ date_short($row->post_date) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer"></div>
        @endforeach
        @endif
       <!-- END SCIENCE -->

        <!-- START SUMMITS -->
        @if(isset($summits) && $summits)
        @foreach($summits as $row)
         <?php $summits_slug=$ci->slug->create_slug($row->title,1); ?>
            <div class="row ">
                <div class="bsdo_11">
                    <div class="bdr">
                        <div class="row news-content">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="m_h">
                                    <h4><a title="" href="{{$base_url}}news/details/{{$summits_slug}}/{{$row->id}}">{{ $row->title }}</a></h4>
                                    <div class=" hover01 column">
                                    <?php
                                        $img_summits=$base_url.'asset/news/'.$row->feature_img;
                                        if(file_exists('asset/news/'.$row->feature_img))
                                        {
                                            $img_summits=$base_url.'asset/news/'.$row->feature_img;
                                        }
                                    ?>
                                    <a href="{{$base_url}}news/details/{{$summits_slug}}/{{$row->id}}"><figure><img style="max-height:205px;margin:0 auto;" alt="{{ $row->title }}" src="{{ $img_summits }}" class="img-responsive "></figure></a>
                                    </div>
                                    <?php $striped_desc_summits=strip_tags($row->short_desc,'<img><a>'); ?>
                                    <p><a href="{{$base_url}}news/details/{{$summits_slug}}/{{$row->id}}">{{ word_limiter($striped_desc_summits,35,'..') }}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="row date_category">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 c">
                                <p>
                                <?php 
                                $category=current_news_category_model::get_text($row->category_id);
                                $category_summits=$ci->slug->create_slug($category,1); 
                                ?>
                                <a href="{{ $base_url }}news/categorized/{{ $row->category_id }}/{{ $category_summits }}"><span class="category">{{$category}}</span></a>
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 d">
                                <p><span class="date"><i class="fa fa-calendar"></i>{{ date_short($row->post_date) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer"></div>
        @endforeach
        @endif
        <!-- END SUMMITS -->
        </div>
    </div>
</div>