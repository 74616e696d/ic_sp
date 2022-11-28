@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Current World</h4>
			</div>
			<div class="bx bx-body">
			<ul class="list-group qa">
				{{$current_world}}
			</ul>
			
			{{$links}}
			</div>
		</div>
	</div>
</div>

@stop

@section('style')
<style>
.qa
{

}
.qa li
{
	line-height:30px;
}
.cur
{
	/*background:#0177BF;*/
}

.cur>a
{
	color:#0177BF !important;
	font-weight:bold;
	background:#fff !important;
}
.hnt
{
	font-size:13px;
	/*font-style:italic;*/
}

.hnt>p
{
	margin-top: 0;
}
</style>
@stop

@section('script')
<script type="text/javascript">
	$(document).bind('keydown', 'ctrl+s', function(){$('#save').click(); return false;});
	 $(document).bind("contextmenu",function(e){
	        return false;
	 }); 
</script>
@stop