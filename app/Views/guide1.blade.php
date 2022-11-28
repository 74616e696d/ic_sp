@extends('front_master.master')

@section('content')
<div class="container custom">
	<div class="row d" id='d1'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<h4 class='hlght'>User Panel</h4>
		<p><span class='hlght'>Login</span> করার পর আপনি পাচ্ছেন একটি Dashboard, যা থেকে
		আপনি দেখে নিতে পারছেন একটি <span class='hlght'>Menu Bar</span>-</p>
		<ul class='list-unstyled'>
			<li>- User Panel</li>
			<li>- Study &amp; Practice</li>
			<li>- Previous Job Test</li>
			<li>- Model Test</li>
			<li>- Current Affairs</li>
			<li>- Mistake List</li>
			<li>- Review List</li>
			<li>- My Statistics</li>
			<li>- Important Rules</li>
			<li>- Iconpreparation Forum</li>
		</ul>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd1.jpg" class='img-responsive' alt=''>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d2'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd2.jpg" class='img-responsive' alt=''>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>study &amp; Practice</h4>
			<p>আপনিএখানে গেলে দেখতে পাবেন সব বিষয়ের অধীন চ্যাপ্টারসমূহ।প্রতিটি চ্যাপ্টারের পাশে আপনি দেখবেনঃ
- Previous Test Count [এই চ্যাপ্টার থেকে বিভিন্ন পরীক্ষায় আগে কতবার প্রশ্ন এসেছে] এই নাম্বারটি দেখে আপনি সিদ্ধান্ত নিতে পারবেন কোন চ্যাপ্টার আপনার বেশি পড়া উচিত।
- Start Practice
- Start Quiz
- Read Details
		</p>
		
		</div>

	<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d3'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Previous Job Test</h4>
			<p>Previous Job Test বলতে আমরা বুঝিয়েছি বিগত বিসিএস এবং ব্যাংক এর পরীক্ষাসমূহ। আপনি এখানে পাচ্ছেন ১০ম থেকে ৩৪তম সব বিসিএস এর প্রশ্ন এবং গত ৩বছরে ব্যাংকে যত পরীক্ষা হয়েছে তার পূর্ণাঙ্গ প্রশ্ন এবং সমাধান। আপনি প্র্যাকটিস করতে পারেন একটি একটি প্রশ্ন করে কিংবা Real Test থেকে একবারে যাচাই করতে পারেন আপনি এই পরীক্ষায় কত পেতেন।</p>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd3.jpg" class='img-responsive' alt=''>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d10'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd4.jpg" class='img-responsive' alt=''>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Model Test</h4>
			<p>সিলেবাস অনুযায়ী বিসিএস ও ব্যাংকের উপর পূর্নাঙ্গ মডেল টেস্ট দিতে পারবেন এবং বিষয় ভিত্তিক মডেল টেস্ট এ অংশগ্রহ করতে পারবেন।</p>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d4'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Current World</h4>
			<p>সমসাময়িক বিষয় সম্পর্কে জানতে পারবেন এবং পরীক্ষা দিয়ে নিজেকে যাচাই করতে পারবেন।</p>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width="577" src="{{$base_url}}asset/frontend/img/guide/gd5.jpg" class='img-responsive' alt=''>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d5'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd7.jpg" class='img-responsive' alt=''>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Mistake List</h4>
			<p>Mistake List এ ক্লিক করে আপনি প্র্যাকটিস করার সময় Quiz এবং Model Test এ যা ভুল করেছেন তা দেখতে পাবেন। ভুলগুলো বারবার পড়ে শুধরে নিন এবং শিখা হয়ে গেলে Mistake Listথেকে প্রশ্নটি Delete করে দিন।</p>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>
	<div class="row d" id='d6'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Review List</h4>
			<p>কোন প্রশ্ন কঠিন মনে করলে Add to review  তে ক্লিক করুন। পরে Add to reviewList  থেকে এই প্রশ্ন আবার দেখে নিন।</p>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd6.jpg" class='img-responsive' alt=''>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d7'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd8.jpg" class='img-responsive' alt=''>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>My Statistics</h4>
			<p>My Statistics থেকে আপনি কোন পরীক্ষার কত নম্বর পেয়েছেন তা জানতে পারবেন। 
আপনার Quizএবং  Model Testএর ফলাফল দেখে নিতে পারবেন।
Strength Comparison  এ আপনি একটি বিষয়ে কোন চ্যাপ্টারে কতগুলো ভুল করেছেন তা দেখে নিতে পারবেন। যেমন :  আপনি বাংলা নাটকে ৭০% শুদ্ধ উত্তর দিয়েছেন এবং জন্ম-মৃত্যু চ্যাপ্টারে ১০০% ভুল করেছেন । Strength Comparison থেকে এভাবে আপনি কোন চ্যাপ্টার এ বেশি দুর্বল তা চিহ্নিত করতে পারবেন। 
</p>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d8'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h4 class='hlght'>Important Rules</h4>
			<p>Important Rulesএ ক্লিক করলে আপনি অনেক গুরুত্বপূর্ণ তথ্য একসাথে গুছিয়ে পড়তে পারবেন এবং বিভিন্ন সূত্র/নিয়মাবলী সম্পর্কে জানতে পারবেন-</p>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img width='577' src="{{$base_url}}asset/frontend/img/guide/gd9.jpg" class='img-responsive' alt=''>
		</div>
		<a href="" class="btn btn-info btn-next">Next &gt;&gt;</a>
	</div>

	<div class="row d" id='d9'>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<img width="577" src="{{$base_url}}asset/frontend/img/guide/gd10.jpg" class='img-responsive' alt=''>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<h4 class='hlght'>Iconpreparation Forum</h4>
		<p>Iconpreparation Forumএ ক্লিক করে আপনি আপনার মতামত, সমালোচনা, আদেশ, প্রস্তাবনা পোস্ট করতে পারবেন।</p>
		</div>
		<!-- <a href="" class="btn btn-info btn-next">Next &gt;&gt;</a> -->
	</div>
</div>
@stop

@section('style')
<style>

	.d
	{
		position:relative;
	}
	.d:hover .btn-next
	{
		display: block;
		width:70px;
		position: absolute;
		left:30%;
		top:30%;
	}

	.btn-next
	{
		display:none;
	}
	.custom
	{
		
	}

	.hlght
	{
		color:#1F87C6;
	}

	.custom .row
	{
		background:#F1F1F1;
		margin-top:15px;
		margin-bottom:15px;
	}
</style>
@stop

@section('script')
<script type="text/javascript">
$('.btn-next').click(function(e){
	e.preventDefault();
	var id=$(this).parent('div').next('div').attr('id');

	if(id=='undefined')
	{
		goToTop('d1');
	}
	else
	{
		goToByScroll(id);
	}
	
});
function goToByScroll(id){
id = id.replace("link", "");
  // Scroll
$('html,body').animate({
    scrollTop: $("#"+id).offset().top},
    'slow');
}

function goToTop(id){
id = id.replace("link", "");
  // Scroll
$('html,body').animate({
    scrollTop: $("#"+id).offset().bottom},
    'slow');
}
</script>

@stop