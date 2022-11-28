@extends('admin_master.layout')

@section('content')

<!-- <form action="{{ $base_url }}fix_seperator/fix"> -->
	<button class='btn btn-info btn-lg' id='btn_fix'><i class="fa fa-refresh"></i>&nbsp;Fix</button>
	<p style='height:50px;' id='msg'></p>
<!-- </form> -->

@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/css/loader.css">
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.isloading.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn_fix').click(function(e){
			e.preventDefault();
				$('#msg').isLoading({
			      text: "Loading",
			      position: "overlay"
			      });

			$.ajax({
				url: '{{ $base_url }}fix_seperator/fix',
				type: 'GET',
			})
			.done(function(data) {
				$( "#msg" ).isLoading( "hide" );
				$('#msg').html(data);
			});
			
		});
	});
</script>
@stop