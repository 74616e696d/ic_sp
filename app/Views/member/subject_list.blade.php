@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<div class="bx-title">Subject Wise Quiz</div>
			</div>
			<div class="bx bx-body">
			<div class="form-inline">
				<select class='form-control' name="ddl_cat" id="ddl_cat">
					@if($cats)
					@foreach($cats as $ct)
					<option value="{{ $ct->id }}">{{ $ct->name }}</option>
					@endforeach
					@endif
				</select>
				<button class='btn btn-info' id='btn_search'><i class="fa fa-search"></i>&nbsp;Search</button>
			</div>
			<br class="clearfix">
				<div class="table-responsive">
					{{ $subjects }}
				</div>
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/css/loader.css">
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/js/jquery.isloading.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#btn_search').click(function(e) {
		e.preventDefault();
		var cat=$('#ddl_cat').val();

			$('.table-responsive').isLoading({
		      text: "Loading",
		      position: "overlay"
		      });

		$.ajax({
			url: '{{ $base_url }}member/subject_list/get_subjects',
			type: 'POST',
			data: {cat:cat},
		})
		.done(function(data) {
			$('.table-responsive').html(data);
			$( ".table-responsive" ).isLoading( "hide" );
		});
		
	});
});
</script>
@stop