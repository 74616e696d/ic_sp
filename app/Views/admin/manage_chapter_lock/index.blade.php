@extends('admin_master.layout')

@section('content')
<table class="table table-bordered table-stripped">
	<thead>
		<tr>
			<th>Chapter</th>
			<th>Is Locked</th>
		</tr>
	</thead>
	<tbody>
		@if($chapters)
		@foreach($chapters as $cpt)
		<tr>
			<td>{{$cpt->name}}</td>
			<td>
			<?php 
			$cls_btn=$cpt->is_paid?'btn btn-danger btn-lock':'btn btn-default btn-lock';
			$cls_icon=$cpt->is_paid?'fa fa-lock':'fa fa-unlock';
			$locked=$cpt->is_paid?0:1;
			 ?>
			<button type='button' data-chapter='{{$cpt->id}}' data-locked='{{$locked}}' class='{{$cls_btn}}'>
				<i class="{{$cls_icon}}"></i>
				<span>{{$cpt->is_paid?'Locked':'Not Locked'}}</span>
			</button>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>
@stop



@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('.table').on('click','.btn-lock',function(){
		var chapter=$(this).data('chapter');
		var locked=$(this).data('locked');
		var that=$(this);

		$.ajax({
			url: '{{$base_url}}admin/manage_chapter_lock/lock_chapter',
			type: 'GET',
			data: {chapter:chapter,locked:locked}
		})
		.done(function(data) {
			if(data=='success')
			{
				if(locked==1)
				{
				that.removeClass('btn btn-default btn-lock');
				that.addClass('btn btn-danger btn-lock');
				that.children('i').removeClass('fa fa-unlock');
				that.children('i').addClass('fa fa-lock');
				that.children('span').text('Locked');
				that.data('locked',0)
				}
				else
				{
				that.removeClass('btn btn-danger btn-lock');
				that.addClass('btn btn-default btn-lock');
				that.children('i').removeClass('fa fa-lock');
				that.children('i').addClass('fa fa-unlock');
				that.children('span').text('Not Locked');
				that.data('locked',1)
				}
			}
		});
		
		// alert(chapter+' '+is_locked);
		
	});

});
</script>
@stop