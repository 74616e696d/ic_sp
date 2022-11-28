@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx bx-title">{{$chapter_name}}</h4>
			</div>
			<div class="bx bx-body">
				<div id="detail-content">
				{{$details}}
				</div>
				<div id='page'></div>
				<div class="row">
					@if($media)
					<h5>See the following video regarding this chapter</h5>
						@foreach ($media as $m)
						<div class="col-sm-6">
							{{$m->media_url}}
						</div>
						@endforeach
					@endif

					@if(!$is_written)
					<a style='margin-left:10px;' class='btn btn-pad btn-danger' href="{{$base_url}}member/chapter_quiz/index/{{$chapter_id}}">Take A Quiz</a> 
					<a class="btn btn-pad btn-warning" href="{{$base_url}}member/reading/index/{{$chapter_id}}">See All Questions</a><br>
					@endif

				</div>
				
				
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<style>
	h5{
		padding-left:14px;
	}

	.btn-pad
	{
		padding: 8px 12px;
		font-size: 16px;
	}
	.btn-link
	{
		/*font-size: 16px;*/
	}
	.violet
	{
		background: #1D0C39;
		color:#fff;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/vendor/pagination/jquery.simplePagination.js"></script>
<script type="text/javascript">
$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
 $(document).bind("contextmenu",function(e){
        return false;
 }); 


$(document).ready(function() {
	 var lines=$('#detail-content').html().split('<hr class="page-break">');
	 var divs='';
	 var count=lines.length;
	 $.each(lines, function(i, line) {
	 	divs+="<div class='page-content'>"+line+"</div>"; 
	 });
	 
	 $('#detail-content').html(divs);

	 if(count>1)
	 {
	 	$('#detail-content').html(lines[0]);
	 	var pg='';
	 	pg+="<ul class='pager'>";
	 	pg+="<li class='previous'><a href=''><i class='fa fa-arrow-circle-left'></i>&nbsp;Previous Page</a></li>";
	 	pg+="<li class='next'><a href=''>Next Page&nbsp;<i class='fa fa-arrow-circle-right'></i></a></li>";
	 	pg+="</ul>";
	 	$('#page').html(pg);
		 var i=0;
		 $('.next>a').on('click',function(e){
		 	e.preventDefault();
		 	$('#detail-content').html(lines[i+1]);
		 	var last=count-1;
		 	if(last!=i) i++;
		 });

		 $('.previous>a').on('click',function(e){
		 	e.preventDefault();
		 	$('#detail-content').html(lines[i-1]);
		 	if(i!=0)i--;
		 });
	 }
	 else
	 {
	 	$('#detail-content').html(divs);
	 }
});
</script>
@stop