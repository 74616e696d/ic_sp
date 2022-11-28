@extends('front_master.master')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 com-xs-10 col-sm-offset-1  ns-dtls">
            <div class="conatainer">
                @if($news)
                <div style='padding:10px;background:#f0f0f0;'>
                    <h3>
                        {{$news->
                        title}}
                    </h3>
                    <div class="news-details">
                        {{ $news->
                        details }}
                        @if(!empty($news->
                        link))
                        <p>
                            For More Details
                            <a target='_blank' href="{{$news->link}}">
                                {{!empty($news->
                                link_text)?$news->
                                link_text:$news->
                                link }}
                            </a>
                        </p>
                        @endif
                        @if(!empty($news->
                        publish_date))
                        <?php $dt=date_create($news->
                        publish_date);$dtf=date_format($dt,'M d,Y'); ?>
                        <p>
                            Published on: {{$dtf}}
                        </p>
                        @endif
                    </div>
                </div>
                <hr/>
                @endif
                <h3>
                    <u>
                        সকল নোটিশ সমুহ
                    </u>
                </h3>
                @if($all_news)
                <?php $columns =3;
                $rows = ceil(count($all_news) / $columns); ?>
                <ul class='list-unstyled'>
                    @for($row = 0; $row < $rows; $row++)
                    @foreach ($all_news as $k=>
                    $item)
                    <!-- @if($k % $rows == $row) -->
                    <li>
                        <a style='color:#444' href="<?php echo $base_url(); ?>job/details/{{ $item->id }}">
                            {{ $item->
                            title }}
                        </a>
                    </li>
                    <!-- @endif -->
                    @endforeach
                    @endfor
                </ul>
                @endif
            </div>
        </div>
    </div>
</section>
@stop
@section('style')
<style>
    body{
    overflow-x: hidden;
    }
    h3
    {
    font-size:19px;
    }
    .conatainer div
    {
    font-size:13px;
    }
    .list-unstyled li a
    {
    font-size:14px;
    }
    .ns-dtls
    {
    min-height:450px;
    }
</style>
@stop
@section('script')
@stop
