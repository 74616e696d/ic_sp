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
							<p class="bcs"><b style='text-transform: uppercase; line-height: 30px;'>* সামনে বিসিএস ও ব্যাংক এর পরীক্ষা দুটোই আছে। এই দুটোর সম্মিলিত প্রস্তুতির জন্য আমাদের এই মডেলটেস্ট প্রোগ্রাম। </b></p>
							
						
		                </div>
		                <div class="col-xs-10 col-xs-offset-1">
		                	
		                		
		                		<p class="bcs"><b style='text-transform: uppercase; line-height: 30px;'> প্রথমে দুই পরীক্ষার কমন টপিক নিয়ে পরীক্ষা হবে, তারপর আলাদা আলাদা
		                			টপিক বেইজড পরীক্ষা হবে। তাছাড়া ব্যাংক এর প্রশ্ন হবে আর্টস ফ্যাকাল্টি,সোশ্যাল সাইন্স ফ্যাকাল্টি,অস্ট, আইবিএ এর প্যাটার্নে। </b>
		                		</p>
		                		
		                
		                	
		                		<strong>যোগাযোগ: ০১৬২৪৫৯৫৯৫৯</strong>
		                	
		                </div>
		            </div>
		        </div>
		    </section>
			<br>
		

<p style='font-size: 11px;line-height:20px;padding:0px 20px;'>
	<ul>

<li>প্রতি পরীক্ষার তারিখ ও সময় Iconpreparation এর ফেসবুক পেজ এ পাবেন

 </li>


<li>প্রতিটি প্রশ্নের উত্তর ব্যাখ্যা সহ দেয়া থাকবে। </li>
<li>আপনার সাহায্যের জন্যে আমাদের আছে ২৪/৭ সাপোর্ট সেন্টার। </li>

<li>প্রয়োজনীয় টপিকের উপর আইকনপ্রিপ্যারাশন এর কোর্স ম্যাটেরিয়াল ও দেখতে পারবেন স্বল্পমূল্যে।  </li>
<li>প্রয়োজনীয় টপিকের উপর লাইভ ক্লাসও থাকবে।  </li>
<li>নিজস্ব তথ্য আপডেট করতে যে কোন অধ্যায়ের উপর ক্লিক করুন </li> </ul> </p>
		

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

