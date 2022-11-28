@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h3 class="bx-title">
				<a href=''>My Questions</a>
				&nbsp;&nbsp;
				<a  href="">All</a>
				</h3>
			</div>
			<div class="bx bx-body">
				{{ $q_ans }}
				<div style='width:80%; margin:0 auto;'>
				<div class="fb-comments" data-href="{{$base_url}}member/req_ask_list/view_ans/{{$qid}} ?>" data-width='100%' data-numposts="5" data-colorscheme="light"></div>	
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<style>
	.qlst
	{
		margin-bottom:4px;
	}
	.qlst li h4
	{

	}
	.qlst li p:first
	{

	}
	.qfooter span
	{
		margin-right:20px;
	}
	.qfooter span i
	{
		margin-right:3px;
	}
	.q_ans
	{
		background:#E0EAF1;
		padding:10px 5px;
	}
</style>
@stop

@section('script')
<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1390651954534358";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
@stop