@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
	<div class="bx">
		<div class="bx bx-header">
			<h4 class="bx-title">Model Test Result</h4>
		</div>
		<div class="bx bx-body">
		 <div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Model Test</th>
						<th>Date</th>
						<th>Total Correct</th>
						<th>Total Wrong</th>
						<th>Time Taken</th>
						<th>Score</th>
						<th>Your Top Score</th>
						<th>Top Score</th>
						<th>View All</th>
					</tr>
				</thead>
				<tbody>
				{{$quiz}}
				</tbody>
			</table>
		 </div>
		</div>
	</div>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
	// $(document).ready(function() {
		$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
		 $(document).bind("contextmenu",function(e){
		        return false;
		 }); 
	// });
</script>
@stop