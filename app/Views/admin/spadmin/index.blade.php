@extends('admin_master.layout')

@section('content')
<textarea name="txtSql" id="txtSql" style='width:95%;' rows="5" class="form-control"></textarea>
<button type="button" id='btnSql' class="btn btn-sm btn-info">GO</button>
<br>
<div id="result">
	
</div>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#btnSql').click(function(){
		var sql=$('#txtSql').val();
		$.ajax({
			url: '{{$base_url}}admin/spadmin/get_result',
			type: 'GET',
			data: {term: sql}
		})
		.done(function(res) {
			$('#result').html(res);
		});
		
	});
});
</script>
@stop