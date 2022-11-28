@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx-header">
				<h4 class="bx-title">{{ $exam_name }}</h4>
			</div>
			<div class="bx bx-body">
				<ul class='list-group'>
					{{ $qlist }}
				</ul>
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
<style>
.hnts
{
	font-size:12px;
	font-weight:normal;
}
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
	 $(document).bind("contextmenu",function(e){
	        return false;
	 }); 
</script>
@stop