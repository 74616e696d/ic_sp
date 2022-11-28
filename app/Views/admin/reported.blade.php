@extends('admin_master.layout')

@section('content')
<ul class="list-group">
	{{$question}}
</ul>

@stop

@section('style')
<style>
.list-ques
{
	margin-bottom:5px;
}
.list-ans
{
	padding-left:35px;
	border:none;
}
.correct-ans
{
	color:green;
	font-weight:bold;
}
</style>
@stop

@section('script')
@stop