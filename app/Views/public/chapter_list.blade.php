@extends('front_master.master')

@section('content')

<div class="container">
<ol class="breadcrumb">
	<li>Home</li>
	<li>{{$exam}}</li>
	<li>{{$subj}}</li>
	<li class="active">Chapters</li>
</ol>
	@if($chapters_group)
	@foreach($chapters_group as $cgrp)

	<?php $chapters=$ci->ref_text_model->get_ref_text_by_parent($cgrp->id); ?>


	@if($chapters)

	@foreach($chapters as $cpt)
	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
		<div class="panel panel-primary">
			<div class="panel-body">
			   {{$cpt->name}}
			</div>
		  <div class="panel-footer">
		  		<ul class='list-inline'>
		  			<?php
		  			$lnk_practice=$is_auth?$base_url."member/reading/index/{$cpt->id}":$base_url.'public/user_reg';
		  			$lnk_quiz=$is_auth?$base_url."member/chapter_quiz/index/{$cpt->id}":$base_url.'public/user_reg';
		  			$lnk_read=$is_auth?$base_url."member/read_details/index/{$cpt->id}":$base_url.'public/user_reg';
		  			?>
		  			<li><a href="{{ $lnk_practice }}"><i class="fa fa-edit"></i> Practice</a></li>
		  			<li><a href="{{ $lnk_quiz }}"><i class="fa fa-pencil"></i> Quiz</a></li>
		  			<li><a href="{{ $lnk_read }}"><i class="fa fa-book"></i> Read</a></li>
		  		</ul>
			</div>
		</div>
	</div>
	@endforeach
	@endif

	@endforeach
	@endif

</div>

@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/table.css">
<style>
.panel-footer{
	background:#0177BF;
}
.panel-footer a{
	color:#fff;
}
.panel-footer a:hover{
	text-decoration: none;
}
.list-inline{
	margin-bottom: 0;
}
.list-inline li:not(:last-child){
	border-right:1px solid #ccc;
}
</style>
@stop

@section('script')
@stop