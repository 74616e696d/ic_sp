@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx bx-title">{{$hints?$hints['title']:''}}</h4>
			</div>
			<div class="bx bx-body" style='min-height:500px;'>
				{{$hints?$hints['details']:''}}

				<ul class="pager">
					@if($start==$max_indx)
					<li class="disabled"><a href="">Previous</a></li>
					@else
					<?php $e=$start+1; ?>
					<li><a href="{{$base_url}}member/days_hints/index/{{$e}}">Previous</a></li>
					@endif

					<?php //$s=$start-1; 
						//$next_hints=$study_hints_model->has_hints($s);
					?>
					@if($next_hints)
					<li><a href="{{$base_url}}member/days_hints/index/{{$s}}">Next</a></li>
					@else
					<li class="disabled"><a href="">Next</a></li>
					@endif
					
				</ul>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
 $(document).ready(function(){

 	$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
 	 $(document).bind("contextmenu",function(e){
 	        return false;
 	 }); 
 	 
 });
</script>

@stop