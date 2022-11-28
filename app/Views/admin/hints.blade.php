@extends('admin_master.layout')

@section('content')
@if($hints)
<ul class="list-group">
	@foreach($hints as $hint)
	<li class="list-group-item">{{ $hint->hints }}</li>
	@endforeach
</ul>
@endif
@stop