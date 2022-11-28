@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h3 class="bx-title">Details Result Of  &nbsp;&nbsp;{{$exam_name}}</h3>
			</div>
			<div class="bx bx-body">
				{{$result}}
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