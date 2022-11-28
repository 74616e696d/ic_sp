@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/written_ques/store" class="form-horizontal">
		<div class="control-group">
			<label for="category" class="control-label">Exam Category</label>
			<div class="controls">
			<select required='required' name="category" id="category">
				<option value="">Select Category</option>
				@if($cats)
				@foreach($cats as $ct)
				<?php $sel_cat=old_value('cat')==$ct->id?'selected':''; ?>
				<option {{$sel_cat}} value="{{$ct->id}}">{{$ct->name}}</option>
				@endforeach
				@endif
			</select>
			</div>
		</div>
		<div class="control-group">
			<label for="exam_name" class="control-label">Exam Name</label>
			<div class="controls">
			<select name="exam_name[]" id="exam_name" multiple>
				<option value="">Select Exam Name</option>
			</select>
			</div>
		</div>

		<div class="control-group">
			<label for="subject" class="control-label">Subject</label>
			<div class="controls">
			<select name="subject" id="subject">
			<option value="">Select Subject</option>
			</select>
			</div>
		</div>

		<div class="control-group">
			<label for="chapter" class="control-label">Chapter</label>
			<div class="controls">
				<select name="chapter" id="chapter">
					<option value="">Select Chapter</option>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="ques" class="control-label">Question</label>
			<div class="controls">
				<textarea name="ques" required='required' id="ques" cols="30" rows="10"></textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="ans" class="control-label">Answer</label>
			<div class="controls">
				<textarea name="ans" id="ans" cols="30" rows="10"></textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="" class="control-group"></label>
			<div class="controls">
				<button type="submit" name='save' class='btn btn-info' value="1"><i class="fa fa-save"></i> Save</button>
				<button type="submit" name='save_new' class='btn btn-primary' value="2"><i class="fa fa-save"></i> Save &amp; Continue</button>

				<a href="{{$base_url}}admin/written_ques" class='btn btn-danger'><i class="fa fa-times-circle"></i> Cancel</a>
			</div>
		</div>
</form>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace('ques');
	CKEDITOR.replace('ans');
	CKEDITOR.config.width='550px';
	CKEDITOR.config.height='120px';

	//setting old value
	var old_cat='{{old_value('cat')}}';
	if(old_cat.length>0){
		var old_exam='{{json_encode(old_value('exam'))}}';
		$.ajax({
			url:'{{$base_url}}admin/written_ques/get_prev_exam',
			type:'POST',
			data:{eid:old_cat,sel_exam:old_exam}
		})
		.done(function(data){
			$('#exam_name').html(data);
		});

		var old_sub='{{old_value('subject')}}';
		$.ajax({
			url:'{{$base_url}}admin/written_ques/get_subjects',
			type:'POST',
			data:{eid:old_cat,sel_subj:old_sub}
		})
		.done(function(data){
			$('#subject').html(data);
		});

		if(old_sub.length>0)
		{
			var old_chap='{{old_value('chapter')}}';
			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_chapters',
				type:'POST',
				data:{subj:old_sub,sel_chap:old_chap}
			})
			.done(function(data){
				$('#chapter').html(data);
			});
		}

	}
	//end setting old value


	$('#category').change(function() {
		var eid=$(this).val();
		if(eid!="")
		{
			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_subjects',
				type:'POST',
				data:{eid:eid}
			})
			.done(function(data){
				$('#subject').html(data);
			});

			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_prev_exam',
				type:'POST',
				data:{eid:eid}
			})
			.done(function(data){
				$('#exam_name').html(data);
			});

		}
		else
		{
			$('#subject').html("<option value=''>Select Subject</option>");
			$('#exam_name').html("<option value=''>Select Exam Name</option>");
		}
	});


	$('#subject').change(function(){
		var cid=$(this).val();
		if(cid!="")
		{
			$.ajax({
				url:'{{$base_url}}admin/written_ques/get_chapters',
				type:'POST',
				data:{subj:cid}
			})
			.done(function(data){
				$('#chapter').html(data);
			});
		}
		else
		{
			$('#chapter').html("<option value=''>Select Chapter</option>");
		}
	});

});
</script>
@stop