@extends('admin_master.layout')

@section('content')
{{ $subj_list }}
@stop


@section('style')
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('label.btn').live('click',function(e)
		{
			e.preventDefault();
			var stat=$(this).attr('data-stat');
			if(stat==0)
			{
				$(this).attr('data-stat', '1');
				$(this).children('i').removeClass('fa fa-lock fa-black');
				$(this).children('i').addClass('fa fa-unlock fa-green');
				$(this).children('span').text('Unlocked');

			} 
			else if(stat==1)
			{
				$(this).attr('data-stat', '0');
				$(this).children('i').removeClass('fa fa-unlock fa-green');
				$(this).children('i').addClass('fa fa-lock fa-black');
				$(this).children('span').text('Locked');
			}
			var stat=$(this).attr('data-stat'),
				rid=$(this).children('input[type=hidden]').val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/exam_lock/save_lock_state',
				type: 'POST',
				data: {stat:stat,rid:rid},
			})
			.done(function($data) {
				
			});
			
			
		});
	});
</script>
@stop