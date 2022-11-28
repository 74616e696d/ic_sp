@extends('admin_master.layout')

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
			<select name="ddl_subject" id="ddl_subject">
				<option value="-1">Select Subject</option>
			</select>

		</div>
		<div class="span3">
			<button id='btn_search' class="btn btn-info"><i class="fa fa-search"></i>&nbsp;Search</button>
		</div>
		
	</div>
</fieldset>
<br>
<div id='contentDiv' class="span12">
	
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

		/**
		 * Get Subject By Exam Category
		 */
		$('#ddl_cat').change(function(){
			var cat_id=$(this).val();
			$.ajax({
				url: '{{$base_url}}admin/exam_lock/get_subjects',
				type: 'GET',
				data: {eid:cat_id},
			})
			.done(function(data) {
				$('#ddl_subject').html(data);
			});
			
		});


		/**
		 * Get Chapter By Subject
		 */
		$('#btn_search').click(function(e){
			e.preventDefault();
			var eid=$('#ddl_cat').val(),
				subj=$('#ddl_subject').val();
			$.ajax({
				url: '{{$base_url}}admin/exam_lock/get_chapter_list',
				type: 'POST',
				data: {eid:eid,subj:subj},
			})
			.done(function(data) {
				$('#contentDiv').html(data);
			});
			
		});

		/**
		 * Lock/Unlock a Cchapter
		 */
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
		});//End Lock/Unlock Chapter

	});
</script>
@stop