@extends('master.layout')

@section('content')
<div class="bx">
	<div class="bx bx-header">
		<h3 class="bx-title">Syllabus</h3>
	</div>
	<div class="bx bx-body">
		<form class='form-inline'>
		 <select style="width:250px;" type="text" id='ddl_exam' class="form-control">
		 	<option value="0">Select Exam</option>
		 	@if($exams)
	 		@foreach($exams as $exam)
	 		<option {{$exam->id==7?'selected':''}} value="{{$exam->id}}">{{$exam->name}}</option>
	 		@endforeach
		 	@endif
		 </select>
		</form>
		<div id="syllabus">
			
		</div>
	</div>
</div>
@stop

@section('style')
<style>
	#syllabus
	{
		padding-left: 10px;
	}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){
	//default syllabus
	var exam_id=$('#ddl_exam').val();
	load_instruction(exam_id);
	//end default syllabus

	$('#ddl_exam').change(function(){
		var eid=$(this).val();
		if(eid!=0)
		{
			
			load_instruction(eid);
		}
	});
});
function load_instruction(eid)
{
	$.ajax({
		url: '{{$base_url}}member/syllabus/load_syllabus',
		type: 'POST',
		data: {eid: eid},
	})
	.done(function(res) {
		$('#syllabus').html(res);
	});
}
</script>
@stop