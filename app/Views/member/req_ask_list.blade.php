@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h3 class="bx-title" style='width:100% !important'>
				<a href=''>My Questions</a>
				&nbsp;&nbsp;
				<a  href="">All</a>
			<a style='margin-right:5px;' class='pull-right btn btn-info btn-xs' href="{{ $base_url }}member/ask_question">Ask a question&nbsp;<i class="fa fa-question-circle"></i></a>
				</h3>
			</div>
			<div class="bx bx-body">
				{{ $qlist }}
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<style>
	.qlst
	{
		margin-bottom:4px;
	}
	.qlst li h4
	{

	}
	.qlst li p:first
	{

	}
	.qfooter span
	{
		margin-right:20px;
	}
	.qfooter span i
	{
		margin-right:3px;
	}
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		
	});
</script>
@stop