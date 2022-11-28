@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
	<div class="bx">
		<div class="bx bx-header">
			<h4 class="bx-title">Chapter Progress</h4>
		</div>
		<div class="bx bx-body">
		 <div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Chapter Name</th>
						<th>Date</th>
						<th>Total Correct</th>
						<th>Total Wrong</th>
						<th>Time Taken</th>
					</tr>
				</thead>
				<tbody>
					@if($quiz)
					@foreach($quiz as $q)
					<tr>
						<td>{{ref_text_model::get_text($q->chapter_id)}}</td>
						<?php $dt=date_create($q->quiz_date);$dtf=date_format($dt,'d F, Y H:i A'); ?>
						<td>{{$dtf}}</td>
						<td>{{$q->total_correct}}</td>
						
						<?php $qid=$q->quiz_id; $splited=!empty($qid)?explode('_', $qid):'0'; $time=$splited[0];?>
						<td>
						<a data-toggle="tooltip" title="View Wrong List" class='btn btn-danger' href="{{$base_url}}member/chapter_quiz_wrong/index/{{$q->chapter_id}}/{{$time}}">
						<i class="fa fa-list"></i>&nbsp;&nbsp;{{$q->total_wrong}}</a>
						</td>

						<?php $tm=gmdate('H:i:s',$q->time_taken); ?>
						<td>{{$tm}}</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		 </div>
		</div>
	</div>
	</div>
</div>

@stop

@section('script')
@stop