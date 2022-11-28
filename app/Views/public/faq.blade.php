@extends('front_master.master')
@section('content')
<div class="container">
	<div class="panel-group" id="accordion">
	    <h3 class="faqHeader">Frequently Asked Questions</h3>
	    <?php $sl=1; ?>
		@foreach($faqs as $row)
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collaspe{{$sl}}">{{$sl}}.) {{$row['ques']}}</a>
						</h4>
					</div>
					<div id="collaspe{{$sl}}" class="panel-collapse collapse in">
						<div class="panel-body">
						{{$row['ans']}}
						</div>
					</div>
				</div>
				<?php $sl++; ?>
		@endforeach
	</div>
</div>
@stop

@section('style')
<style>
	    .faqHeader {
	        font-size: 27px;
	        margin: 20px;
	    }
	    .panel{box-shadow: none;}
	    .panel-default{
	    	border-color: #fff;
	    }
	    .panel-heading [data-toggle="collapse"]:after {
	        font-family: 'FontAwesome';
	        /*content: "\f0d7";*/
	        float: right;
	        color: #F58723;
	        font-size: 18px;
	        line-height: 22px;
	    }

	    .panel-heading [data-toggle="collapse"].collapsed:after {
	        -webkit-transform: rotate(180deg);
	        -moz-transform: rotate(180deg);
	        -ms-transform: rotate(180deg);
	        -o-transform: rotate(180deg);
	        transform: rotate(180deg);
	        color: #454444;
	    }
	    .panel-title{
	    	font-size: 15px;
	    }
	    .panel-title a:hover{
	    	text-decoration: none !important;
	    }
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#myCollapsible').on('hidden.bs.collapse', function () {
		  // do something…
		})
	});
</script>
@stop