@extends('front_master.master')

@section('content')
<!-- <div id="banner">
		<h2>
		<a href="{{$base_url}}forum/forum/posts">
			Iconpreparation Forum
		</a>
		</h2>
</div>
 -->
<div class="main-content">
	<div class="container">
		<div id="content" class="main-content-inner">
		
			<div class="row">
				<!-- middle side -->
				
				<div class="col-sm-12 col-md-9">

					<div class="panel panel-default">
						<div class="panel-heading">
							@if(!empty($details->feature_image)  
							 && file_exists('./asset/upload/forum/'.$details->feature_image))
							<img width="100%"  src="{{ $base_url }}asset/upload/forum/{{ $details->feature_image }}" alt="$details->title">
							<br><br>
							@else
							<img width="100%" src="{{ $base_url }}asset/upload/forum/blank.jpg" alt="$details->title">
							<br><br>
							@endif
							<h3 class="panel-title post-title">
							<a rel="bookmark" href="{{$base_url}}forum/forum/replies/{{$details->id}}">
				                {{!empty($details->title)?$details->title:'Untitled'}}
				             </a>
				            </h3>
						</div>
						<div class="panel-body">
							<ul class="list-inline">
								<li>
									<?php
										$fb_image= '/asset/frontend/img/banner.jpg';
										if(file_exists('asset/upload/forum/' . $post->feature_image))
										{
											$fb_image= '/asset/upload/forum/'.$post->feature_image;
										}
										// $post_details=strip_tags($details->details,'<sub><sup><img><u><i><b><strong><br><p>');
										$post_details = $post->details;
										$url= "//forum/replies/".$post->id;
										$title=!empty($post->title)?$post->title:'Iconpreparation';
										// $summery= word_limiter(strip_tags($post_details),70);
										$summery = '';
									?>
									<a class="social social-facebook btnShare" href="{{$url}}" data-title="{{$title}}" data-picture="{{ $fb_image }}" data-desc="{{$summery}}"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									
									<a href="" class="social social-twitter hide"><i class="fa fa-twitter"></i></a>
								</li>
							</ul>
							<h5>date_short($post->post_date)</h5>
							@if($post)
							<input type="hidden" id="hdn_post_id" value="{{$post->id}}">
							<article class="post-89 post type-post status-publish format-standard hentry category-2 tag-bcs-examination-marks-distribution tag-bcs-written-syllabus" id="post-89">

							    <div class="row">
						            <div class="post-content-wrap col-sm-12 col-md-12">
					                    <div class="entry-content">
				                        	<p>{{$post_details}}</p>
											@include('forum.footer')
				                        </div>
										<!-- .entry-content -->

				                        <footer class="footer-meta">
				                            <div class="cat-tag-meta-wrap">
				                                <span class="cats-meta">
				                                <i class="fa fa-folder"></i>
				                                <a rel="category tag" href="{{$base_url}}forum/forum/posts/{{$post->sub_category}}">
				                                  @if($post->sub_category==5000)
					                                User Post
					                                @else
					                                ref_text_model::get_text($details->sub_category)
					                                @endif
				                                </a>
				                                </span>

				                                <span class="entry-author">
				                                <i class="fa fa-user"></i> <span class="author vcard entry-author-link">
				
				                                $user=user_model::get_user_name($post->user_id);
				                                $post_by=!empty($user)?$user:'Anonymous';
				                                <a rel="author" title='{{$post_by}}' href="">{{$post_by}}</a>
				                                </span>
				                                </span>

			                                <span class="entry-author">
			                                	
			                                	<a style='padding:3px;' href="{{$url}}" data-title="{{$title}}" data-picture="{{ $fb_image }}" data-desc="{{$summery}}" class="btn btn-primary btn-xs btnShare">
			                                	&nbsp;&nbsp;<i class="fa fa-facebook"></i>
			                                	Share <span data-current-count='0' class=" badge fbCount">0</span>
			                                	</a>
			                                </span>
				                            </div>

											<nav>
				                            <ul class="pager">
				                            	@if(false && $next_prev_post['prev_id']>0)
				                            	<li class='previous'><a href="{{$base_url}}forum/forum/replies/{{$next_prev_post['prev_id']}}">Previous Post</a></li>
				                            	@else
				                            	<li class='previous disabled'><a href="">Previous Post</a></li>
				                            	@endif

				                            	@if(false && $next_prev_post['next_id']>0)
				                            	<li class='next'><a href="{{$base_url}}forum/forum/replies/{{$next_prev_post['next_id']}}">Next Post</a></li>
				                            	@else
				                            	<li class='next disabled'><a href="">Next Post</a></li>
				                            	@endif
				                            </ul>
				                            </nav>
			                            </footer><!-- .entry-meta -->
		                            </div>
		                        </div><!--.row-->
							</article>
							@endif
						</div>
						<div class="panel-footer">
								<div class="bx bx-body">
									<textarea name="reply" id="reply" class="form-control" placeholder='Write Your reply'></textarea>
									<button id='btn_reply' class="btn btn-info btn-xs">Reply</button>
									<span id='msg' style='color:#900;'></span>
									<div class="clearfix"></div>
								</div>
								<br/>
								<div id="reply_container">
								{{$replies}}
								</div>

								<div>
									<h3>Comment with facebook</h3>
									<div class="fb-comments" data-href="{{$base_url}}forum/forum/replies/{{$details->id}}" data-numposts="5"></div>
								</div>
						</div>
					</div>
				
				</div>
				<!-- end left side -->

				<!-- right side -->
				<div class="col-sm-12 col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Categories</h3>
						</div>
						<div class="panel-body">
							@if(isset($categorised_post) && $categorised_post)
							<ul class="nav">
								@foreach($categorised_post as $cat)
								<li class="cat-item cat-item-1">
								<a href="{{$base_url}}forum/forum/posts/{{$cat->sub_category}}"> {{$cat->name}}
								<span class='badge pull-right'>{{$cat->total_post}}</span></a>
								</li>
								@endforeach
								<li class="cat-item cat-item-1">
									<a href="{{$base_url}}forum/forum/posts/5000">Users Posts
									<span class='badge pull-right'>{{$user_post}}
									</a>
								</li>
							</ul>
							@endif
						</div>
					</div>
				</div>
				<!-- end right side -->
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/forum.css">
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/feature.css">
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/current_news_flipcard.css">
<style type="text/css" media="screen">
	html, body,h1,h2,h3,h4,h5 {
  color: #444;
  font-family: "Roboto",sans-serif,banglaFonts;
  font-size: 14px;
  font-weight: 300;
}
	.panel{
		border:none;
		box-shadow: none;
	}
	.panel .panel-heading{
		background:#fff !important;
		border-bottom: none;
	}

	.panel .panel-footer{
		background:#f6f6f6;
	}
	.panel-heading h3{
		font-size: 2em;
		line-height: 2.2em;
	}
	.panel-heading h5{
		font-size: 13px;
		line-height: 24px;
	}
	.panel-body{
		line-height: 24px;
		border:none;
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
	.widget-title{
		margin-top: 2px;
		border-bottom: 1px solid #ccc;
		padding-bottom: 8px;
	}
	.page-header
	{
		background: #fff;
		padding-top: 0;
	}
	article.post .entry-content
	{
		font-size: 14px;
	}
	.page-header h1
	{
		font-size: 28px;
	}
	.comments_count i:before
	{
		color:#fff;
	}
	.entry-title{
		line-height: 
	}
	.post-form
	{
		border:1px solid #EEEEEE;
		padding:10px;
		margin-bottom:10px;
	}
	.nav > li > a
	{
		/*padding:5px 15px;*/
		font-size: 14px;
	}
	.btn-group, .btn-group-vertical
	{
		padding-top: 0;
	}

	.footer-meta{
		background: #fff;
	}
	footer.main section.widgets
	{
		font-size: 100% !important;
	}
	ol, ul
	{
		font-size: 100% !important;
	}
	.feature
	{
		background:#00A2E8;
		color:#fff;
	}
	.nav > li > a{
		font-size: 13px;
		color:#444 !important;
	}
	#banner{
		/*min-height: 200px;*/
		padding-top:50px;
		padding-bottom: 50px;
		background: #1EB9E5;
	}
	#banner h2{
		font-size: 300%;
		font-weight: 400;
		text-align: center;
	}
	#banner h2 a,#banner h2 a:hover{
		color: #fff;
		text-decoration: none;
	}

	.social{
		width:40px;
		height:40px;
		line-height: 40px;
		font-size: 18px;
		border-radius: 50%;
		display: block;
		text-align: center;
		text-decoration: none;
		color: #fff !important;
	}
	.social-facebook{
		background: #3A5BA2 !important;
	}
	.social-twitter{
		background: #03A9F4 !important;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/flip/jquery.flip.min.js"></script>
<script type="text/javascript">
$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
$(document).bind('keydown', 'ctrl+u', function(){$('#save').click(); return false;});
 $(document).bind("contextmenu",function(e){
        return false;
 }); 
$(document).ready(function(){
	$(".flip-card").flip({
	  trigger: 'hover',
	  reverse: true
	});
	$(document).prop('title','{{!empty($details->title)?$details->title:"Untitled"}} || Iconpreparation');
	$('#mark').click(function(e){
		e.preventDefault();
		var post_id=$(this).data('post');
		var reply=$(this).data('reply');
		$.ajax({
			url:'{{$base_url}}forum/forum/mark',
			type:'GET',
			data:{post:post_id,reply:reply}
		})
		.done(function(data){
			if(data==1)
			{
				$('#mark').css('color','green');
			}
		});

	});

	$('#btn_reply').click(function(){
		var auth='{{$is_auth}}';
		if(auth=='1')
		{
			var post_id=$('#hdn_post_id').val();
			var reply=$('#reply').val();
			if(reply.length>0)
			{
				$.ajax({
					url:'{{$base_url}}forum/forum/save_reply',
					type:'POST',
					data:{post_id:post_id,reply:reply}
				})
				.done(function(data){
					$('#reply').val('');
					refresh_comment_num(post_id);
					refresh_comment(post_id);
					console.log('successfully posted!');
				});
			}
			else
			{
				alert('Reply cannot empty');
			}
		}
		else
		{
			$('#msg').html('You must login to post a comment!');
		}
	});

});

function refresh_comment_num(post)
{
	$.ajax({
		url:'{{$base_url}}forum/forum/total_comment',
		type:'GET',
		data:{post_id:post}
	}).done(function(data){
		$('#ttl_cmnt').html(data);
	});
}

function refresh_comment(pid)
{
	var uid='{{$details->user_id}}';
	$.ajax({
		url:'{{$base_url}}forum/forum/refresh_comment',
		type:'POST',
		data:{pid:pid,uid:uid}
	})
	.done(function(data){
		$('#reply_container').html(data);

	});
}

/**
 * post to feed facebook
 */
function postToFeed(title, desc, url, image)
{
	var imgUrl=image;
	var obj = {method: 'feed',link: url, picture:imgUrl,name: title,description: desc};
	console.log(imgUrl);
	function callback(response){}
	FB.ui(obj, callback);
}

$('.btnShare').click(function(e){
	e.preventDefault();
	elem = $(this);

	postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'),elem.data('picture'));
	countShare('{{$base_url}}forum/forum/replies/{{$details->id}}');
	return false;
});

// var shareUrl=$('.btnShare').prop('href');
var shareUrl='{{$base_url}}forum/forum/replies/{{$details->id}}';
countShare(shareUrl);
function countShare(shareUrl){
	$.getJSON('http://graph.facebook.com/' + shareUrl, function (json) {
		console.dir(json);
	    return setCount($('.fbCount'), json.shares);
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

@section('fbmeta')

<?php
$current_url=current_url();
$current_url=str_replace('index.php/', '', $current_url);
?>
<meta property="og:url" content="{{ $current_url }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $details->title }}" />
<meta property="og:description" content="{{ strip_tags($post_details) }}" />

@stop
