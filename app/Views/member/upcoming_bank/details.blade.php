@extends('master.layout')

@section('content')
<div class="bx">
	<div class="bx-header">
		<h3 class="bx-title">{{ ref_text_model::get_text($details->topics) }}</h3>
	</div>
	<div class="bx-body">
		{{ $details->details }}

		<div class="clearfix"></div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<h3>Discussion</h3>
			<div class="form-group">
				<textarea name="comment" id="comment" class='form-control'></textarea>
				<button data-rid='{{ $details->id }}' class="btn btn-info btn-xs btn-comment">Post</button>
			</div>

			<div class="comment-box">
				
			</div>
		</div>


		@if($tops)
		<div style='margin-left:0 !important;padding-left:0 !important;' class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-lg-offset-4 col-md-offset-4">
				<h3>Today's Top Scorer</h3>
				@if($tops)
				@foreach($tops as $top)
				<div class="media">
					<a class="pull-left" href="#">
					<?php $img_url=!empty($top->photo)?$base_url.'asset/images/upload/'.$top->photo:$base_url.'asset/img/no-image.jpg'; ?>
						<img width='50' class="media-object" src="{{ $img_url }}" alt="Image">
					</a>
					<div class="media-body">
						<h4 class="media-heading">{{ !empty($top->user_name)?$top->user_name:$top->email }}</h4>
						<p><strong>Total Correct : </strong>{{ $top->points }}</p>
					</div>
				</div>
				@endforeach
				@else
				@endif
			</div>
		</div>
		@endif
		<div class="clearfix"></div>

	</div>
</div>
@stop

@section('style')
<style>
	.bx-body p{
		width:100%;
		line-height: 25px;
	}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	load_comment();
	$('.btn-comment').click(function(){
		var rid=$(this).data('rid');
		var comment=$('#comment').val();
		$.ajax({
			url: '{{ $base_url }}member/cexam/make_comment',
			type: 'POST',
			data: {rid:rid,comment:comment}
		})
		.done(function(res) {
			$('#comment').val('')
			load_comment();
		});
	});
});

/**
 * get all comments
 */
function load_comment()
{
	var rid='{{ $details->id }}';
	$.ajax({
		url: '{{ $base_url }}member/cexam/get_comments',
		type: 'POST',
		data: {rid: rid}
	})
	.done(function(res) {
		$('.comment-box').html(res);
	});
}
</script>
@stop