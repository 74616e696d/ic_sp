@extends('admin_master.layout')

@section('content')
<div class="span6 offset3">
	<form class='form-inline' method='get' action="{{$base_url}}admin/manage_assigned_question/index">
	<select name="eid" id="ddl_exams">
	@if($exams)
	@foreach ($exams as $e)
	<?php $testname=empty($e->ref_id)?$e->test_name:ref_text_model::get_text($e->ref_id); ?>
		<option value="{{$e->id}}">{{$testname}}</option>
	@endforeach
	@endif
	</select>
	<button value="1" class="btn btn-info" type="submit"><i class="fa fa-search"></i>&nbsp;Search</button>
	</form>
	
</div>
<div class="span7 offset2">
	{{$ques_list}}
</div>
@stop

@section('script')
<script type="text/javascript">
	function deleteQues(qid,eid)
	{
		var conf=confirm("Are you sure to delete??");
		if(conf)
		{
			window.location.href='{{$base_url}}/admin/manage_assigned_question/remove/'+qid+'/'+eid;
		}
	}
</script>
@stop