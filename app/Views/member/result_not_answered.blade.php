@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title"></h4>
			</div>
			<div class="bx bx-body">
				{{ $list }}
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