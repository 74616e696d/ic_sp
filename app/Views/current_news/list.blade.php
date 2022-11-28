@extends('front_layout.layout')

@section('content')
<h2 class='current-news'>Current News</h2>
<div class="container">
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-pad">
		<ul class='news-cat'>
			<li><a href="/news/all">All</a></li>
			@if(isset($category) && $category)
				@foreach($category as $cat)
				<?php
					$data=['title'=>$cat->name];
					$cat_slug=$ci->slug->create_uri($data,1);
				 ?>
				<li><a href="{{$base_url}}news/{{$cat_slug}}">{{$cat->name}}</a></li>
				@endforeach
			@endif
		</ul>
	</div>
	<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
		@if(isset($featured) && $featured)
		<img height="180px" src="{{$base_url}}asset/news/{{$featured->feature_img}}" alt="Current News">
		<div class="cat-title">
			<span>
				{{current_news_category_model::get_text($featured->category_id)}}
			</span>
		</div>
		<h3 class='news-title'>
			{{$featured->title}}
		</h3>
		<div class="news-date">
		<?php
		$dt=date_create($featured->post_date);
		$dtf=date_format($dt,'M d,Y');
		?>
		{{$dtf}}
		</div>
		<div class="news-details">
			{{$featured->short_desc}}
			<p class='text-left'><a href="{{$base_url}}news/{{$featured->id}}">Read More..</a></p>
		</div>
		@endif
		<ul class="list-group">
			<li class="list-group-item active">Latest Current Affairs</li>
			@if(isset($top_news) && $top_news)
				@foreach($top_news as $top)
					<li class="list-group-item">
						<div class="media">
							<a class="pull-left" href="#"><div class="media-title"></div></a>
							<div class="media-body">
							{{$top->title}}
							</div>
						</div>
					</li>
				@endforeach
			@endif
		</ul>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div role="tabpanel" class='news-tabs'>
		    <!-- Nav tabs -->
		    <ul class="nav  nav-justified nav-tabs" role="tablist">
		        <li role="presentation" class="active">
		            <a href="#Latest" aria-controls="Latest" role="tab" data-toggle="tab">On this day</a>
		            <div class="arrow-down" style='display:none'></div>
		        </li>
		        <li role="presentation">
		            <a href="#tab" aria-controls="tab" role="tab" data-toggle="tab">Upcoming Events</a>
		            <div class="arrow-down" style='display:none'></div>
		        </li>
		    </ul>

		
		    <!-- Tab panes -->
		    <div class="tab-content">
		        <div role="tabpanel" class="tab-pane active" id="Latest">
		        	<ul class='news-list-right'>
		        		@if(isset($on_this_day) && $on_this_day)
			        		@foreach($on_this_day as $row)
			        		<li>{{$row->title}}</li>
			        		@endforeach
		        		@endif
		        	</ul>
		        </div>
		        <div role="tabpanel" class="tab-pane" id="tab">
		        	<ul class='news-list-right'>
		        	@if(isset($upcoming_events) && $upcoming_events)
			        	@foreach($upcoming_events as $row)
			        	<li>
			        		<div class="media">
			        			<div class="media-body upcoming-event">
			        				<h4 class="media-heading"><a href="">Media heading</a></h4>
			        				<?php 
			        					$dt=date_create($row->event_time);
			        					$dtf=date_format($dt,'M d, Y');
			        					$time=date_format($dt,'H:i a');
			        				 ?>
			        				<p><i class="fa fa-calendar"></i> {{$dtf}}</p>
			        				<p><i class="fa fa-clock-o"></i> {{$time}}</p>
			        			</div>
			        		</div>
			        	</li>
			        	@endforeach
		        	@endif
		        	</ul>
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

@section('style')
	<link rel="stylesheet" href="/asset/frontend/css/current_news.css">
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
});
</script>
@stop