@extends('admin_master.layout')


@section('content')
	<p>
	</p>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th width="25%">Post</th>
				<th width="38%">Comments</th>
				<th>Comment Date</th>
				<th>Display</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		@if($comments)
			@foreach($comments as $comment)
			<tr>
				<td>{{$comment->title}}</td>
				<td>{{$comment->details}}</td>
				<?php
				$cmnt_date=date_create($comment->comment_date);
				$cmnt_date_format=date_format($cmnt_date,'d-m-Y');
				?>
				<td>{{$cmnt_date_format}}</td>
				<td>
				<label>
				<input type="checkbox" class='comment_display' data-id='{{$comment->id}}' name="display" {{$comment->display?'checked':''}} id="display" value="1">
				<span>{{$comment->display?'Published':'Not Published'}}</span>
				</label>
				</td>
				<td>
					@if($comment->viewed_by_admin)
					<a href="" data-toggle='tooltip' data-id='{{$comment->id}}' title='Mark As View' class="btn btn-success btn-small btn-mark">
					<i class="fa fa-check"></i>
					</a>
					@else
					<a href="" data-toggle='tooltip' data-id='{{$comment->id}}' title='Mark As View' class="btn btn-warning btn-small btn-mark">
					<i class="fa fa-check"></i>
					</a>
					@endif
					<a target='_blank' href="{{$base_url}}forum/forum/replies/{{$comment->forum_post_id}}" data-toggle='tooltip' title='View Post' class="btn btn-info btn-small">
					<i class="fa fa-eye"></i>
					</a>
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	{{$comment_pagination}}
@stop


@section('style')
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	/**
	 * mark as viewed
	 */
	$(".btn-mark").click(function(e){
		e.preventDefault();
		var id=$(this).data('id');
		var that=$(this);
		$.ajax({
			url: '{{$base_url}}admin/manage_forum_comment/update_view_status',
			type: 'GET',
			data: {comment_id: id}
		})
		.done(function(res) {
			if(res=='1')
			{
				that.removeClass('btn-warning');
				that.addClass('btn-success');
			}
			else
			{
				alert('unbale to mark!!');
			}
		});
	}); //end mark as viewed


	/**
	 * update display status
	 */
	$('.comment_display').click(function(){
		var comment_id=$(this).data('id');
		var that=$(this);
		var status=that.is(':checked')?1:0;
		$.ajax({
			url: '{{$base_url}}admin/manage_forum_comment/update_display_status',
			type: 'GET',
			data: {comment_id: comment_id,status:status}
		})
		.done(function(res) {
			if(res=='1')
			{
				var status_text=status==1?'Published':'Not Published';
				that.next('span').text(status_text);
			}
			else
			{
				alert('Something wrong !!');
			}
		});//end update display status
		
	});
});
</script>
@stop