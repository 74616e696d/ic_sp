@extends('admin.master.master')

@section('content')
<form class="form-horizontal" action="<?php echo base_url(); ?>school/admin/chapter_details/add" method="post">
	<div class="form-inline">
	<label for="ddl_exam_cat">Exam Category:</label>
	<select name="ddl_exam_cat" id="ddl_exam_cat">
		<option value="-1">Select Class</option>
		@if($classes)
			@foreach ($classes as $cls)
				<option value='{{$cls->id}}'>{{ $cls->name }}</option>
			@endforeach
		@endif
	</select>
	<label for="ddl_subject">Subject:</label>
	<select name="ddl_subject" id="ddl_subject">
		<option value="">Select Subject</option>
	</select>
	<label for="ddl_chapter">Chapter:</label>
	<select name="ddl_chapter" id="ddl_chapter">
		<option value="-1">Select Chapter</option>
	</select>
	</div>
	<br>
	<div id="dlts">
		<label for="txt_tips">Hot Tips:</label>
	<div>
		<textarea name="txt_tips" id="txt_tips"></textarea>
	</div>
	<br>
	<label for="txt_details">Details:</label>
		<textarea name="txt_details" id="txt_details"></textarea>
	</div>
	<br/>
	 <button type="submit" class="btn btn-default"><i class="icon icon-ok-circle"></i>&nbsp;&nbsp;&nbsp;Save</button>

	 <a href="{{ $base_url }}school/admin/chapter_details" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
</form>

@stop
	
@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('txt_tips');
		CKEDITOR.replace('txt_details');
		$('#ddl_exam_cat').change(function(){
			var eid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>school/admin/chapter_details/get_subjects',
				type: 'POST',
				data: {eid:eid},
			})
			.done(function(data) {
				$('#ddl_subject').html(data);
			});
		});


		$('#ddl_subject').change(function() {
			var subj=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>school/admin/chapter_details/get_chapters',
				type: 'POST',
				data: {subj:subj},
			})
			.done(function(data) {
				$('#ddl_chapter').html(data);
			});
		});

		$('#ddl_chapter').change(function(){

			var chapter=$(this).children(':selected').val();
			if(chapter!=-1)
			{
					$.ajax({
					url: '<?php echo base_url(); ?>school/admin/chapter_details/get_ref_details',
					type: 'GET',
					dataType:'json',
					data: {rid:chapter},
					})
					.done(function(res) {
						CKEDITOR.instances['txt_tips'].setData(res.tips);
						CKEDITOR.instances['txt_details'].setData(res.details);
					});

			}
		});
	});
</script>
@stop