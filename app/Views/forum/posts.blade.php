<?php
use App\Models\Ref_text_model;
$Ref_text_model= new Ref_text_model();
?>
@extends('front_master.master')

@section('content')
<div class="main-content">
	<div class="container">
		<div id="content" class="main-content-inner">
		
			<div class="row">
				<!-- middle side -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='padding-bottom: 15px;'>
					<a href="" id='btn-cat' class='btn btn-default'>
						<i class="fa fa-bars"></i> Categories
					</a>

					<a href="{{ base_url() }}/forum/posts/create" class="btn btn-default"><i class="fa fa-plus-circle"></i> New Post</a>
				</div>
				<div class="col-sm-12 col-md-12">
				@if($posts)
				 <div class="row">
					@foreach($posts as $post)
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="panel" id="post-{{$post->id}}">
							
							<div class="panel-body">
							@if(!empty($post->feature_image)  
							 && file_exists('./public/asset/upload/forum/'.$post->feature_image))
							<img width="100%" src="{{ base_url() }}/public/asset/upload/forum/{{ $post->feature_image }}" alt="$post->title">
							@else
							<img width="100%" src="{{ base_url() }}/public/asset/upload/forum/blank.jpg" alt="$post->title">
							@endif
								
							</div>
										<div class="panel-heading">
											<h3 class="panel-title">
												<a rel="bookmark" href="{{base_url()}}/forum/replies/{{$post->id}}/{{ $post->getSlug() }}">
													{{ !empty($post->title) ? $post->title : 'Untitled' }}
												</a>
											</h3>
																
											                       <!--  <a href="{{$base_url}}forum/forum/replies/{{$post->id}}/{{$title}}" class="read-more">
											                       Read More →</a> -->
										</div>
							<div class="panel-footer">
								<ul class='list-inline pull-right'>
									<li> 
									<a rel="category tag" href="{{base_url()}}forum/forum/posts/{{$post->sub_category}}">
		                                @if($post->sub_category==5000)
		                                User Post
		                                @else
		                                {{ $Ref_text_model->get_text($post->sub_category) }}
		                                @endif
		                             </a>
	                                </li>
								</ul>

								<ul class='list-inline'>
								<li><i class="fa fa-user"></i> 
								<?php 
								$user= null;
								$post_by=!empty($user)?$user:'Anonymous';
								?>
								<a rel="author" title="Posts by {{$post_by}}" href="">{{$post_by}}</a>
								</li>
								<li><i class="fa fa-clock-o"></i><?php echo date_short($post->post_date) ?></li>
								</ul>
									
								<div class="clearfix"></div>
							
							</div>
						</div>
					</div>
					@endforeach 
				</div>
				{{$page_link}}                     
				@endif				
				</div>
				<!-- end middle side -->

				<!-- right side -->
				<div class="floating-nav hide" data-show='0'>
					<div class="sidebar">
						<div class="sidebar-padder">
							<aside class="widget widget_categories" id="categories-2">
								@if($postCategories)
								<ul class="nav">
								<li><h3 class="widget-title">Categories</h3></li>
								
									@foreach($postCategories as $cat)
									<li class="cat-item cat-item-1">
									<a href="/forum/posts/{{$cat->sub_category}}"> {{ $cat->name }} <span class='badge pull-right'>{{ $cat->total_post }}</span></a>
									</li>
									@endforeach
									<li class="cat-item cat-item-1">
										<a href="forum/posts/5000">Users Posts 
										<span class='badge pull-right'>{{$user_post}}
										</a>
									</li>
								</ul>
								@endif		
							</aside>
						</div><!-- close .sidebar-padder -->
					</div><!-- close .sidebar -->
				</div>
				<!-- end right side -->
			</div>
		</div>
	</div>
</div>


@stop


@section('style')
<style type="text/css" media="screen">
	
	html, body,h1,h2,h3,h4,h5 {
	  color: #444;
	  font-family: "Roboto",sans-serif,banglaFonts;
	  font-size: 14px;
	  font-weight: 300;
	}
	.main-content{
		background: #EFEFEF;
	}
	.panel{
		border:none;
		border-top: 5px solid #0177BF;
		min-height: 390px;
		position: relative;
		box-shadow:none;
	}

	.panel:hover,.panel:focus{
		border-top: 5px solid #ED4523;
		box-shadow: 0 0.15em 0.35em 0 rgba(0, 0, 0, 0.133);
	}

	.panel .panel-title a{
		color:#333;
		text-decoration: none;
		font-size: 20px;
		line-height: 30px;
	}

	.panel .panel-title a:hover,.panel .panel-title a:focus{
		color:#000;
	}
	.panel .panel-header{
		border-bottom: 1px solid #f6f6f6;
	}

	.panel .panel-body{
		color:#555;
		font-size: 17px;
		line-height: 24px;
	}

	.panel .panel-footer{
		border:none;
		color:#777;
		background: #fff;
		position: absolute;
		bottom: 0;
		width: 100%;
	}

	.panel .panel-footer a{
		color:#777;
		font-size: 13px;
		text-decoration: none;
	}

	.panel .panel-footer a:hover,.panel .panel-footer a:focus{
		color:#000;
		text-decoration: none;
	}

	.curr a
	{
		background: #f97307 !important;
		color:#f1f1f1 !important;
	}
	.user-panel
	{
		display: none;
	}
	.main-content
	{
		padding-top: 30px;
		padding-bottom:0;
	}
	.page-header h1
	{
		font-size: 28px;
	}
	.comments_count i:before
	{
		color:#fff;
	}
	.post-form
	{
		border:1px solid #EEEEEE;
		padding:10px;
		margin-bottom:10px;
	}
	.nav > li > a
	{
		font-size: 13px;
		color:#444 !important;
	}
	.navbar-home .btn-login{
		color:#fff !important;
	}
	.btn-group, .btn-group-vertical
	{
		padding-top: 0;
	}
	footer.main section.widgets
	{
		font-size: 100% !important;
	}
	ol, ul
	{
		font-size: 100% !important;
	}

	.floating-nav
	{
		padding: 20px;
		position: fixed;
		right: 0;
		top:11%;
		z-index: 10000;
		width: 300px;
		background-color: #f6f6f6;
		color:#444;
		/*min-height: 100%;*/
		overflow-y: auto;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/frontend/js/forum.js"></script>
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<div id="fb-root"></div>
<script type="text/javascript">
CKEDITOR.replace('post',{toolbarStartupExpanded:true});
var baseurl='{{$base_url}}';
</script>
<script type="text/javascript" src="{{$base_url}}asset/member/js/forum.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#btn-cat').click(function(e){
    	e.preventDefault();
    	var floatingDiv=$('.floating-nav');
    	if(floatingDiv.data('show')==0)
    	{
	    	floatingDiv.data('show',1);
	    	floatingDiv.removeClass('hide');
    	}
    	else
    	{
    		floatingDiv.data('show',0);
    		floatingDiv.addClass('hide');
    	}
    });
	$('.pagination').children('ul').addClass('pagination');
	 $(document).prop('title','Iconpreparation Forum || Iconpreparation');
    $('#category').change(function() {
        var id=$(this).val();
        $.ajax({
            url: '{{base_url()}}forum/forum/get_sub_cat',
            type: 'GET',
            data: {id:id},
        })
        .done(function(data) {
            $('#subcategory').html(data);
        });
    });

});

function postToFeed(title, desc, url, image)
{
	var obj = {method: 'feed',link: url, picture: '{{ base_url() }}/public/asset/frontend/img/'+image,name: title,description: desc};
	function callback(response){}
	FB.ui(obj, callback);
}

$('.btnShare').click(function(){
elem = $(this);
postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'),elem.data('image'));
countShare(elem.prop('href'));
return false;
});

var shareUrl=$('.btnShare').prop('href');
countShare(shareUrl);
function countShare(shareUrl){
	$.getJSON('http://graph.facebook.com/' + shareUrl, function (json) {
	    return setCount($('.btnShare'), json.shares);
	});
}

var countUp = function ($item) {
    return setTimeout(function () {
        var current, newCount, target;
        current = $item.attr('data-current-count') * 1;
        target = $item.attr('data-target-count') * 1;
        newCount = current + Math.ceil((target - current) / 2);
        $item.attr('data-current-count', newCount);
        $item.html(newCount);
        if (newCount < target) {
            return countUp($item);
        }
    }, 100);
};

var setCount = function ($item, count) {
    if (count == null) {
        count = null;
    }
    $item.attr('data-target-count', count);
    $item.attr('data-current-count', 0);
    return countUp($item);
};
</script>
@stop