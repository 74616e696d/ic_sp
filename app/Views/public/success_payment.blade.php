@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title"></h4>
			</div>
			<div class="bx-body">
				<p>
					{{$success_msg}}
				</p>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
@stop