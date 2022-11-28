@extends('master.layout')
@section('content')
{{-- <div class="col-md-12"> --}}
    <div class="bx">
        <div class="bx bx-header">
            <h4 class="bx-title">{{$exam_name}} | Written</h4>
        </div>
        <div class="bx bx-body">
			<ul class='list-group'>
				{{$list}}
			</ul>
        </div>
    </div>
</div>
{{-- </div> --}}
@stop

@section('style')
<style>
	.list-ques
	{
		font-size:15px;
	}
	.list-ans
	{
		background:#f9f9f9;
		/*border:1px solid #f7f7f7;*/
		margin-bottom:10px;		
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