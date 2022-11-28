@extends('admin_master.layout');

@section('content')
	<fieldset>
		<div class="form-horizontal">
		
		<div class="span3">
			<select name="ddl_cat" id="ddl_cat">
				<option value="-1">Select Exam Category</option>
				@if($exam_cat)
					@foreach ($exam_cat as $cat)
						<option value="{{$cat->id}}">{{$cat->name}}</option>
					@endforeach
				@endif
			</select>
		</div>
		<div class="span3">
			<button id='btn_search' class="btn btn-info"><i class="fa fa-search"></i>&nbsp;Search</button>
		</div>
		
	</div>
	</fieldset>
	<br>
	<div id="contentDiv">
		
	</div>
@stop


@section('style')
<style>
.fa-green
{
	color:#B9E077;
}
.fa-black
{
	color:#333;
}
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {

		$('#btn_search').click(function(e){
			e.preventDefault();
			var eid=$('#ddl_cat').val();
			$.ajax({
				url: '{{$base_url}}admin/exam_lock/exam_list',
				type: 'POST',
				data: {eid:eid},
			})
			.done(function(data) {
				$('#contentDiv').html(data);
			});
			
		});

		//$('#contentDiv').off('click','.btn-stat');
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
				url: '<?php echo base_url(); ?>admin/exam_lock/lock_exam',
				type: 'POST',
				data: {stat:stat,rid:rid},
			})
			.done(function($data) {
				
			});
			
			
		});

	});
</script>

@stop