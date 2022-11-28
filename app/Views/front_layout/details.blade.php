@extends('front_layout.layout_forum')

@section('content')
<div id="banner">
	<a href="{{base_url()}}forum/forum/posts"><img src="{{base_url()}}asset/frontend/img/banner.jpg" alt="Iconpreparation Forum"></a>
</div>

<div class="main-content">
	<div class="container">
		<div id="content" class="main-content-inner">
			<!-- <div class="row">
				<div class="col-sm-12 col-md-12">
					<h2>আইকনপ্রিপ্যারাশন ফোরাম</h2>
				</div>
			</div> -->
			<div class="row">
				<!-- left side -->
				@if($is_auth)
				<!-- left side -->
				<div class="col-sm-8 col-md-2">
					@include('master/left')
				</div>
				@endif
				<!-- left side -->

				<!-- middle side -->
				@if($is_auth)
				<div class="col-sm-12 col-md-7">
				@else
				<div class="col-sm-12 col-md-9">
				@endif
					@if($details)
					<input type="hidden" id="hdn_post_id" value="{{$details->id}}">
					<article class="post-89 post type-post status-publish format-standard hentry category-2 tag-bcs-examination-marks-distribution tag-bcs-written-syllabus" id="post-89">

					    <div class="row">
					        <div class="post-meta-info col-sm-12 col-md-2">
					        	<?php $dt=date_create($details->post_date);$month=date_format($dt,'M');$date=date_format($dt,"d"); ?>
					            <div class="entry-meta">
					            <time class="entry-time updated">{{$month}}<strong>{{$date}}</strong></time>
					            <span class="comments_count clearfix entry-comments-link"><i class='fa fa-comment'></i><a href="">{{frm_comment_model::post_comment_count($details->id)}}</a></span>
					            </div><!-- .entry-meta -->
					        </div><!--.post-meta-info-->

				            <div class="post-content-wrap col-sm-12 col-md-10">
				                <header class="page-header">
				                    <h1 class="entry-title"><a rel="bookmark" href="{{base_url()}}forum/forum/replies/{{$details->id}}">{{!empty($details->title)?$details->title:'Untitled'}}</a></h1>
				                </header><!-- .entry-header -->


			                    <div class="entry-content">

		                        	<p>{{strip_tags($details->details,'<sub><sup><img><u><i><b><strong><br><p>')}}</p>

		                        </div><!-- .entry-content -->

		                        <footer class="footer-meta">
		                            <div class="cat-tag-meta-wrap">
		                                <span class="cats-meta">
		                                <i class="fa fa-folder"></i> 
		                                <a rel="category tag" href="{{base_url()}}forum/forum/posts/{{$details->sub_category}}">
		                                {{ref_text_model::get_text($details->sub_category)}}
		                                </a>
		                                </span>

		                                <span class="entry-author">
		                                <i class="fa fa-user"></i> <span class="author vcard entry-author-link">
		                                <?php $post_by=user_model::get_user_email($details->user_id); ?>
		                                <a rel="author" title="Posts by {{$post_by}}" href="">{{$post_by}}</a>
		                                </span>
		                                </span>

	                                <span class="entry-author">
	                                	<?php 
	                                	$url=base_url()."forum/forum/posts#post-".$details->id;
	                                	$title=!empty($details->title)?$details->title:'Iconpreparation';
	                                	$summery=word_limiter(strip_tags($details->details),70);
	                                	 ?>
	                                	<a href="{{$url}}" data-title="{{$title}}" data-picture="banner.jpg" data-desc="{{$summery}}" class="btn btn-primary btn-xs btnShare">
	                                	<i class="fa fa-facebook"></i> Share</a>
	                                </span>
		                            </div>
	                            </footer><!-- .entry-meta -->
                            </div><!--.post-content-wrap-->

                        </div><!--.row-->
					</article>	
					@endif	

					<div class='col-sm-12 col-md-10 col-md-offset-2'>
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
					</div>
				</div>
				<!-- end left side -->

				<!-- right side -->
				<div class="col-sm-12 col-md-3">
					<div class="sidebar">
						<div class="sidebar-padder">
							<aside class="widget widget_recent_entries" id="recent-posts-2">		
								<h3 class="widget-title">Recent Posts</h3>	
								@if($recent)
								<ul class="nav">
									@foreach($recent as $rec)
									<li class="cat-item cat-item-1">
									<a style='width:100%;' href="{{base_url()}}forum/forum/replies/{{$rec->id}}"> {{!empty($rec->title)?$rec->title:'Untitled'}}</a>
									</li>
									@endforeach
								</ul>
								@endif	
							</aside>
							<aside class="widget widget_categories" id="categories-2">
								<h3 class="widget-title">Categories</h3>
								@if($categorised_post)
								<ul class="nav">
									@foreach($categorised_post as $cat)
									<li class="cat-item cat-item-1">
									<a href="{{base_url()}}forum/forum/posts/{{$cat->sub_category}}"> {{$cat->name}} 
									<span class='badge pull-right'>{{$cat->total_post}}</span></a>
									</li>
									@endforeach
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
<link rel="stylesheet" href="{{base_url()}}asset/member/css/forum.css">
<style type="text/css" media="screen">
.user-panel
{
	display: none;
}
.main-content
{
	padding-top: 30px;
	padding-bottom:0;
}
.widget-title{margin-top: 2px;}
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
.post-form
{
	border:1px solid #EEEEEE;
	padding:10px;
	margin-bottom:10px;
}
.nav > li > a
{
	padding:5px 15px;
	font-size: 14px;
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
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){

	$('#mark').click(function(e){
		e.preventDefault();
		var post_id=$(this).data('post');
		var reply=$(this).data('reply');
		$.ajax({
			url:'{{base_url()}}forum/forum/mark',
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
					url:'{{base_url()}}forum/forum/save_reply',
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
		url:'{{base_url()}}forum/forum/total_comment',
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
		url:'{{base_url()}}forum/forum/refresh_comment',
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
	var imgUrl='{{base_url()}}asset/frontend/img/'+image;
	var obj = {method: 'feed',link: url, picture:imgUrl,name: title,description: desc};
	console.log(imgUrl);
	function callback(response){}
	FB.ui(obj, callback);
}

$('.btnShare').click(function(e){
e.preventDefault();
elem = $(this);
postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'),elem.data('picture'));
return false;
});
</script>
@stop