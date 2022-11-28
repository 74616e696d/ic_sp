@extends('front_layout.layout')

@section('content')
<div id="banner">
	<a href="{{$base_url}}forum/forum/posts"><img src="{{$base_url}}asset/frontend/img/banner.jpg" alt="Iconpreparation Forum"></a>
</div>

<div class="main-content">
	<div class="container">
		<div id="content" class="main-content-inner">
		
			<div class="row">
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
					@if($is_auth)
					<div class='post-form'>
					<p>আপনার তথ্য/মতামত/আলোচনা/সমালোচনা পোষ্ট করুন</p>
					<div id='msg'>
					{{render_message()}}
					</div>
					<form action="{{$base_url}}forum/forum/save_post" method='post'>
					    <div class="form-inline">
				            <select class="form-control" name="category" id="category">
				                <option value="">Select Category</option>
				                @if($category)
				                @foreach($category as $c)
				                <option value="{{$c->id}}">{{$c->name}}</option>
				                @endforeach
				                @endif
				            </select> &nbsp;&nbsp;
				            <select class='form-control' name="subcategory" id="subcategory">
				                <option value="">Select Subcategory</option>
				            </select>
					    </div>
				        <input type="text" class="form-control" required="required" name="title" id="title" placeholder='Title'>
				        <textarea class="form-control" name="post" id="post" cols="30" rows="3" placeholder='Write your question or discussion details'></textarea>
				        <br>
				        <button type="submit" id='btn_post' class="btn btn-info btn-sm">Post</button>
						<br>
				    </form>
				    </div>
					@endif
					@if($posts)
					@foreach($posts as $post)
					<article class="post-89 post type-post status-publish format-standard hentry category-2 tag-bcs-examination-marks-distribution tag-bcs-written-syllabus">
					    <div class="row">
					        <div class="post-meta-info col-sm-12 col-md-2">
					        	<?php $dt=date_create($post->post_date);$month=date_format($dt,'M');$date=date_format($dt,"d"); ?>
					            <div class="entry-meta">
					            <time class="entry-time updated">{{$month}}<strong>{{$date}}</strong></time>
					            <span class="comments_count clearfix entry-comments-link"><i class='fa fa-comment'></i>
					            <span style='color:#fff;padding-left:5px;display:inline;'>{{frm_comment_model::post_comment_count($post->id)}}</span>
					            </span>
					            </div><!-- .entry-meta -->
					       </div><!--.post-meta-info-->

				            <div class="post-content-wrap col-sm-12 col-md-10" id="post-{{$post->id}}">
				                <header class="page-header">
				                    <h1 class="entry-title"><a rel="bookmark" href="{{$base_url}}forum/forum/replies/{{$post->id}}">{{!empty($post->title)?$post->title:'Untitled'}}</a></h1>
				                </header><!-- .entry-header -->


			                    <div class="entry-content">

		                        	<p>{{word_limiter(strip_tags($post->details,'<p><br><br/><sub><sup><u><i><b><strong>'),70,'[...]')}}</p>

			                        <a href="{{$base_url}}forum/forum/replies/{{$post->id}}" class="read-more">Read More →</a>

		                        </div><!-- .entry-content -->

		                        <footer class="footer-meta">
		                            <div class="cat-tag-meta-wrap">
		                                <span class="cats-meta">
		                                <i class="fa fa-folder"></i> 
		                                <a rel="category tag" href="{{$base_url}}forum/forum/posts/{{$post->sub_category}}">
		                                {{ref_text_model::get_text($post->sub_category)}}
		                                </a>
		                                </span>

		                                <span class="entry-author">
		                               <i class="fa fa-user"></i> <span class="author vcard entry-author-link">
		                                <?php $post_by=user_model::get_user_email($post->user_id); ?>
		                                <a rel="author" title="Posts by {{$post_by}}" href="">{{$post_by}}</a>
		                                </span>
		                                </span>
										<br>

										<?php 
										$url=$base_url."forum/forum/posts#post-".$post->id;
										$title=!empty($post->title)?$post->title:'Iconpreparation';
										$summery=word_limiter($post->details,70,'[...]');
										 ?>
										<a href="{{$url}}" data-title="{{$title}}" data-image='logo.png' data-desc="{{$summery}}" class="btnShare">Share</a>
		                            </div>
	                            </footer><!-- .entry-meta -->
                            </div><!--.post-content-wrap-->

                        </div><!--.row-->
					</article>	
					@endforeach                      
					@endif				
				</div>
				<!-- end middle side -->

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
									<a style='width:100%;' href="{{$base_url}}forum/forum/replies/{{$rec->id}}"> {{!empty($rec->title)?$rec->title:'Untitled'}}</a>
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
									<a href="{{$base_url}}forum/forum/posts/{{$cat->sub_category}}"> {{$cat->name}} <span class='badge pull-right'>{{$cat->total_post}}</span></a>
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
<link rel="stylesheet" href="{{$base_url}}asset/member/css/forum.css">
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
    $('#category').change(function() {
        var id=$(this).val();
        $.ajax({
            url: '{{$base_url}}forum/forum/get_sub_cat',
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
	var obj = {method: 'feed',link: url, picture: '{{$base_url}}asset/frontend/img/'+image,name: title,description: desc};
	function callback(response){}
	FB.ui(obj, callback);
}

$('.btnShare').click(function(){
elem = $(this);
postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'),elem.prop('image'));
return false;
});
</script>
@stop