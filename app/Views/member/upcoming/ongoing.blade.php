@extends('master.layout')

@section('content')
<div class="bx">
	<div class="bx-header">
		<div class="bx-title">{{ $title }}</div>
	</div>
	<div class="bx-body">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='position: relative;'>
		    <section class="full-color-div">
		        <div class="row">
		            <div class="container">
		                <div class="col-xs-10 col-xs-offset-1">
							<p class="bcs"><b style='text-transform: uppercase;'>{{ $title }}</b></p>
							<p class="text-bcs"><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME</b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p class="text-bcs">JOIN NOW .</p>
		                </div>
		                <div class="col-xs-10 col-xs-offset-1">
		                	<div class="forty-days">
		                		<div class="forty-days-four">
		                			<p>120 <span class="forty-days-days">DAYS</span><span class="crash-crash">CRASH PROGRAM</span></p>
		                			<p class="date-absolute-crash">{{ $start_date }}</p>
		                		</div>
		                	</div>
		                	<div style='color:#f6f6f6'>
		                		<strong>For Details 01994336000</strong>
		                	</div>
		                </div>
		            </div>
		        </div>
		    </section>
			<br>
			<p style='font-size: 14px;line-height:25px;padding:10px 20px;'>** If you have been studying for this exam, you don't need a crash program. You can practice from our Read &amp; Practice Section.</p>
			<br>

			<table class="table table-bordered table-striped">
				<caption class='text-left'>
				<strong>Today's Program</strong>
			{{-- 	@if($roadmap)
				<a href="{{ $base_url }}member/cexam_bank" class='btn btn-sm btn-success pull-right' style='margin-bottom: 15px;'>View All</a>
				@endif --}}
				</caption>
				<thead>
					<tr>
						<th>Study</th>
						<th>Test</th>
					</tr>
				</thead>
				<tbody>
				@if($all)
				@foreach($all as $row)
				<?php $tags=roadmap_details_model::chapter_tag($row->id); ?>
					<tr>
						<td>
						@if($tags)
						@foreach($tags as $tag)
						<a href='{{ $base_url }}member/cexam_bank/details/{{ $tag->id }}' target='_blank' class="label label-default">{{ $tag->name }}</a>
						@endforeach
						@endif
						</td>
						<td>
							<?php 
							$dt=Date('Y-m-d',strtotime($row->exam_date)); 
							$now=Date('Y-m-d');
							?>
							@if($dt<=$now)
							<a target='_blank' href="{{ $base_url }}member/model_quiz/index/{{ $row->test_id }}">
							{{ $row->exam_name }}
							</a>
							@else
							{{ $row->exam_name }}
							@endif
						</td>
					</tr>
				@endforeach
				@else
				<tr>
					<td colspan='2' style='text-align:center;'>No Course Published Yet !</td>
				</tr>
				@endif
				</tbody>
			</table>
		</div>

		<div class="clearfix"></div>
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

