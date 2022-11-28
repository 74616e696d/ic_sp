@extends('admin_master.layout')

@section('content')
	<div class="circle">
		<div class="circle-content">
			Total Users<br/><span>{{$total_user}}</span>
		</div>
	</div>
	
	<div class="circle">
		<div class="circle-content">
			Months Users<br/><span>{{$months_users}}</span>
		</div>
	</div>

	<div class="circle">
		<div class="circle-content">
			Todays Users<br/><span>{{$todays_users}}</span>
		</div>
	</div>
@stop


@section('style')
<style>
	.circle {
	  border:2px solid #0088CC;
	  background: #ddd;
	  border-radius: 50%;
	  float:left;
	  margin-right: 15px;
	  height: 150px;
	  width: 150px;
	}

	.circle-responsive {
	  background: #ddd;
	  border-radius: 50%;
	  height: 0;
	  padding-bottom: 100%;
	  width: 100%;
	}

	.circle-content {
		font-size: 17px;
	  color: #0088CC;
	  float: left;
	  line-height: 1;
	  margin-top: -0.5em;
	  padding-top: 50%;
	  text-align: center;
	  width: 100%;
	}

	.circle-content span
	{
		padding-top: 10px;
		font-size:18px;
	}


</style>
@stop

@section('script')
<script type="text/javascript">
	
</script>
@stop