@extends('master.layout')

@section('content')
<div class="bx">
	<div class="bx-header">
		<div class="bx-title">{{ $title }}</div>
	</div>
	<div class="bx-body">
		    <section class="full-color-div">
		        <div class="row">
		            <div class="container">
		                <div class="col-xs-10 col-xs-offset-1">
							<p class="bcs"><b>BANK EXAM</b></p>
							<p class="text-bcs"><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME</b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p class="text-bcs">JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                </div>
		                <div class="col-xs-10 col-xs-offset-1">
		                	<div class="forty-days">
		                		<div class="forty-days-four">
		                			<p><span>4</span><span class="forty-days-zero">0</span> <span class="forty-days-days">DAYS</span><span class="crash-crash">CRASH PROGRAM</span></p>
		                			<p class="date-absolute-crash">December 10, 2016- January 19, 2017</p>
		                		</div>
		                	</div>
		                </div>
		            </div>
		        </div>
		    </section>
		
		<br>
		<p style='font-size: 14px;line-height:25px;padding:10px 20px;'>** If you have been studying for this exam, you don't need a crash program. You can practice from our Read &amp; Practice Section.</p>
		<br>
		<table class="table table-bordered table-striped">
		@if(!$is_paid)
		<caption>
			<a href="{{ $base_url }}public/upgrade" class='btn btn-sm btn-warning  pull-right' style='margin-bottom: 15px;'>Upgrade Now</a>
		</caption>
		@endif
			<thead>
				<tr>
					<th>Day</th>
					<th>Study</th>
					<th>Test</th>
				</tr>
			</thead>
			<tbody>
			@if($roadmap)
			<?php $d=1; ?>
			@foreach($roadmap as $row)
			<?php $tags=roadmap_details_model::chapter_tag($row->id); ?>
				<tr>
					<td>{{ $d }}</td>
					<td>
					@if($tags)
					@foreach($tags as $tag)
					<a href='{{ $base_url }}member/cexam_bank/details/{{ $tag->id }}' target='_blank' class="label label-default">{{ $tag->name }}</a>
					@endforeach
					@endif
					</td>
					<td>
					@if(!empty($row->test_id))
						<a target='_blank' href="{{ $base_url }}member/model_quiz/index/{{ $row->test_id }}">{{ $row->exam_name }}</a>
					@else
					{{ $row->exam_name }}
					@endif
					</td>
				</tr>
			<?php $d++; ?>
			@endforeach
			@endif
			</tbody>
		</table>
	</div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/roadmap.css">
<style>
	.label{
		margin-right: 5px;
		margin-bottom: 2px;
	}
	.label-default{
		background-color: #d8d8d8;
		color:#000;
	}
	.btn.btn-banner {
	  position: absolute;
	  top: 82%;
	  right: 38%;
	}
	@media(max-width:450px)
	{
		.btn{
		padding:3px 4px;
		font-size: 11px;
		}
	  .btn.btn-banner {
		  position: absolute;
		  top: 17%;
		  right: 10%;
		}

	}
</style>
@stop