@extends('admin_master.layout')

@section('content')
<form class="form-horizontal" action="{{$base_url}}admin/edit_exam_question/update_questions" method="post">
	<div class="control-group">
		<label for="ddl_exam_name" class="control-label">Exam </label>
		<div class="controls">
			<select name="ddl_exam_name" id="ddl_exam_name">
				<option value="">Select Exam</option>
				@if($exams)
				@foreach($exams as $exam)
					 <?php 
					 $test_name=$exam->test_type==15?$exam->test_name:ref_text_model::get_text($exam->ref_id);
					 ?>
					 @if(!empty($test_name))
	                 <option value='{{ $exam->id }}'>{{ $test_name }}</option>
	                 @endif
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="control-group">
		<label for="txt_qid" class="control-label">Questions </label>
		<div class="controls">
			<textarea name="txt_qid" id="txt_qid" style='width:500px;height:150px;'></textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="" class="control-label"> </label>
		<div class="controls">
			<button type="submit" class="btn btn-info">Update</button>
		</div>
	</div>
</form>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#ddl_exam_name').change(function(){
		var eid=$(this).val();
		if(eid.length>0){
			$.ajax({
				url: '{{ $base_url }}admin/edit_exam_question/get_questions',
				type: 'POST',
				data: {eid:eid},
			})
			.done(function(res) {
				$('#txt_qid').text(res);
			});
		}
	});
});
</script>
@stop