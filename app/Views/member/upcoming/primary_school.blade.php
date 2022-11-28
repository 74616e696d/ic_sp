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
							<p class="bcs"><b style='text-transform: uppercase;'>সরকারি প্রাথমিক বিদ্যালয়ে সহকারী শিক্ষক নিয়োগ পরীক্ষা প্রস্তুতি</b></p>
							
						
		                </div>
		                <div class="col-xs-10 col-xs-offset-1">
		                	<div class="forty-days">
		                		<div class="forty-days-four">
		                			<p>৬০ <span class="forty-days-days">দিনের</span><span class="crash-crash">কোর্স</span></p>
		                			<p class="date-absolute-crash">কোর্স শুরু: ১৪ই আগস্ট ২০১৮</p>
		                		</div>
		                	</div>
		                	<div style='color:#f6f6f6'>
		                		<strong>যোগাযোগ: ০৯৬১৭১৭১১৭৭ অথবা ০১৬২৪৫৯৫৯৫৯</strong>
		                	</div>
		                </div>
		            </div>
		        </div>
		    </section>
			<br>
			<p style='font-size: 12px;line-height:25px;padding:10px 20px;'>** যারা আগে থেকেই প্রস্তুতি নিচ্ছেন, তাদের অধ্যায়ভিত্তিক নিজের মতন পড়লেও চলবে।  অধ্যায়ভিত্তিক পড়তে বাম পাশের মেনুতে Read & Practice  এবং মডেল টেস্ট দিতে Model Test ক্লিক করুন। </p>

<p style='font-size: 11px;line-height:20px;padding:0px 20px;'>
	<ul>

<li>প্রতিদিনের অনুশীলনের কন্টেন্ট দেওয়া থাকবে।  এবং আগের দিনের পড়ার উপর একটি কুইজ হবে। </li>
<li>প্রতি ৫/৬ দিন পরে একদিন থাকবে রিভিশনের জন্য।  </li>
<li>পরবর্তী দিন বিগত ৫/৬ দিনের উপর ৮০ নম্বরের মডেল টেস্ট থাকবে।  </li>

<li>আপনার সাহায্যের জন্যে আমাদের আছে ২৪/৭ সাপোর্ট সেন্টার।  </li>
<li>প্রয়োজনীয় টপিকের উপর লাইভ ক্লাসও থাকবে।  </li>
<li>কোর্স ফি: ৫০০ টাকা  </li>
<li>আপডেট করতে যে কোন অধ্যায়ের উপর ক্লিক করুন। </li> </ul> </p>
		

			<table class="table table-bordered table-striped">
				<caption class='text-left'>
				<strong>কোর্স পরিক্রমা</strong>
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

