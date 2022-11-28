@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12 col-lg-12 col-md-12 right-zero-pad">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">My Total Plans</h4>
			</div>
			<div class="bx bx-body">
			@if($plans)
			<ul class="list-group">
				@foreach($plans as $plan)
				<li class="list-group-item">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class='plan-date'>{{ date_short($plan->read_date) }}</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class='plan-name'>
						@if($plan->has_read)
						<strike>{{ $plan->name }}</strike>
						@else
						{{ $plan->name }}
						@endif
						</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<span class='plan-action'>
							@if($plan->has_read)
							<button type='button' data-id='{{ $plan->id }}' data-name='{{ $plan->name }}' data-status='0' class="btn btn-info lnk_plan">Done</button>
							@else
							<button type='button' data-id='{{ $plan->id }}' data-name='{{ $plan->name }}' data-status='1' class="btn btn-default lnk_plan">Done</button>
							@endif
						</span>
					</div>
					<div class="clearfix"></div>
				</li>
				@endforeach
			</ul>
			@endif
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<style>
.plan-date{
}
.plan-name{
}
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {

	$('.list-group').on('click','.lnk_plan',function(e) {
		e.preventDefault();
		var that=$(this);
		var id=$(this).data('id');
		var name=$(this).data('name');
		var status=$(this).data('status');
		$.ajax({
			url: '{{ $base_url }}member/dashboard/update_plan',
			type: 'POST',
			data: {id: id,status:status}
		})
		.done(function(res) {
			if(status==1){
				that.parent('span').parent('li').children('.plan-name').html("<strike>"+name+"</strike>");
				that.removeClass('btn-default');
				that.addClass('btn-info');
			}
			else
			{
				that.parent('span').parent('li').children('.plan-name').html.html(name);
				that.removeClass('btn-info');
				that.addClass('btn-default');	
			}
		});
		
	});
	
});
</script>
@stop