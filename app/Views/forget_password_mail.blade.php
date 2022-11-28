@extends('front_layout.layout')

@section('content')
<div class="container mail-msg">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
		<div class="alert alert-info" role="alert">
			<h1>
				{{$msg}}
			</h1>
		</div>
		
	</div>
</div>

@stop

@section('style')
<style>
    .h1, .h2, .h3, .h4, .h5, .h6, body, h1, h2, h3, h4, h5, h6{
    	font-family:"Roboto",sans-serif;
    }
	.mail-msg{
		padding: 15px 0;
	}
	.mail-msg h1{
		text-align: center;
	}
</style>
@stop
