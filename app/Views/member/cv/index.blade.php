@extends('master.layout')

@section('content')
<div class="box box-info">
	<div class="box-body">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{ $details?$details->video_link:'' }}
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{ $details?$details->description:'' }}
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if($cvs)
			<ul class="list-group">
			<li class="list-group-item active">
				<h4>Example CV Template</h4>
			</li>
			@foreach($cvs as $cv)
			
				<li class='list-group-item'>
				{{ $cv->name }} &nbsp;&nbsp;&nbsp;
				@if($cv->is_external)
				<a target='_blank' href="{{ $cv->file_name }}" style='margin-right:8px;' class='btn btn-default btn-xs pull-right'><i class="fa fa-download"></i> Download CV</a>&nbsp;&nbsp;&nbsp;&nbsp;
				@else
				<a target='_blank' href="{{ $base_url }}asset/cv/{{ $cv->file_name }}" style='margin-right:8px;margin-left:8px;' class='btn btn-default btn-xs pull-right'><i class="fa fa-download"></i> Download CV</a> &nbsp;&nbsp;&nbsp;&nbsp;
				@endif
				@if($cv->cover_external && !empty($cv->cover_letter))
				<a target='_blank' class='pull-right' href="{{ $cv->cover_letter }}" class='btn btn-default btn-xs btn btn-info'><i class="fa fa-download"></i> Download Cover Letter</a> &nbsp;&nbsp;&nbsp;&nbsp;
				@elseif(!empty($cv->cover_letter))
				<a target='_blank' class='btn btn-default btn-xs pull-right' href="{{ $base_url }}asset/cv/{{ $cv->cover_letter }}" class='btn btn-info'>
				<i class="fa fa-download"></i> Download Cover Letter</a>&nbsp;&nbsp;&nbsp;&nbsp;
				@endif
				
				<div class="clearfix"></div>
				</li>
				
			@endforeach
			</ul> &nbsp;&nbsp;&nbsp;
			@endif
		</div>
	<!-- 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		@if($cvs)
		<ul class="list-group">
			<li class='list-group-item'>
				<h4>Example Cover Letter</h4>
			</li>
			@foreach($cvs as $cv)
				<li class="list-group-item">
					@if($cv->cover_external && !empty($cv->cover_letter))
					<a target='_blank' href="{{ $cv->cover_letter }}" class='btn btn-info'><i class="fa fa-download"></i> {{ $cv->cover_letter }}</a>
					@elseif(!empty($cv->cover_letter))
					<a target='_blank' href="{{ $base_url }}asset/cv/{{ $cv->cover_letter }}" class='btn btn-info'>
					<i class="fa fa-download"></i> {{ $cv->cover_letter  }}</a>
					@endif
					<div class="clearfix"></div>
				</li>
			@endforeach
		</ul>
		@endif
	</div> -->
		
		<div class="clearfix"></div>
	</div>
</div>

@stop