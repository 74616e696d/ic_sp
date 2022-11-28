@extends('master.layout')


@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Model Test</h4>
			</div>
			<div class="bx bx-body">
				<div class="tbl-responsive">
					{{ $live_model_test }}
				</div>
				<div class="row row-cat">
				{{$cats_str}}

				</div>
				<br>
				<div class="tbl-responsive">
					{{$modeltest}}
				</div>

			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/css/loader.css">
<style>
.box-cat
{
	/*margin-left: 3px;*/
	min-height: 200px !important;
	
}
.box-cat h4{
	color:#fff !important;
}
.box-cat ul li a {
    color: #fff !important;
}
  @media only screen and (max-width:420px){
  /*	.box-cat .col-lg-6{
  		width:100% !important;

  	}*/
  	/* .col-xs-12 col-sm-12{
  		width: 100%;
  	}*/
  }
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.isloading.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn-cat').click(function(){
		var cat=$(this).data('cat');
		go_to_table();
		$('.tbl-responsive').isLoading({
		    text: "Loading",
		    position: "overlay"
		    });
		$.ajax({
			url: '{{$base_url}}member/model_test/test_list',
			type: 'GET',
			data: {cat: cat},
		})
		.done(function(data) {
			$('.tbl-responsive').html(data);
			$( ".tbl-responsive" ).isLoading( "hide" );
		});
	});
	// $('#btn_search').click(function(){
	// 	var cat=$('#category').val();
	// 	$('.tbl-responsive').isLoading({
	// 	    text: "Loading",
	// 	    position: "overlay"
	// 	    });
	// 	$.ajax({
	// 		url: '{{$base_url}}member/model_test/test_list',
	// 		type: 'GET',
	// 		data: {cat: cat},
	// 	})
	// 	.done(function(data) {
	// 		$('.tbl-responsive').html(data);
	// 		$( ".tbl-responsive" ).isLoading( "hide" );
	// 	});
		
	// });
});

function go_to_table()
{
  $('html, body').animate({
        'scrollTop' : $(".tbl-responsive").position().top
    });
}
</script>
@stop