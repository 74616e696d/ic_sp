<form method="post" action="{{$base_url}}admin/modeltest/remove_ques">
@if($has)
<button style='margin-left:28px' id='btn_delete' class='btn btn-danger'><i class="fa fa-trash-o"></i>Delete</button>
<br>
<br>
@endif

<ul class="list-group">
	{{$questions}}

</ul>
</form>
<script type='text/javascript'>
// $(document).on('click','#btn_delete',function(){
// 	// var qid=new Array();
// 	var qid=$(".list-group li input[type='checkbox']:checked").serialize();
// 	$.ajax({
// 		url: '{{$base_url}}admin/modeltest/remove_ques',
// 		type: 'GET',
// 		data:qid,
// 	})
// 	.done(function() {
// 		console.log("success");
// 	});
	
// });
</script>