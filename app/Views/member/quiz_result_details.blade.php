@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<div class="bx-title">Quiz Details</div>
			</div>
			<div class="bx bx-body">
				{{$quiz_lists}}
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/exam.css">
@stop

@section('script')
@stop