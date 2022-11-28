@extends('master.layout')

@section('content')
<div class="bx">
	<div class="bx-header">
		<h3 class="bx-title">{{ ref_text_model::get_text($details->topics) }}</h3>
	</div>
	<div class="bx-body">
		{{ $details->details }}
	</div>
</div>
@stop

@section('style')
<style>
	.bx-body p{
		width:100%;
		line-height: 25px;
	}
</style>
@stop