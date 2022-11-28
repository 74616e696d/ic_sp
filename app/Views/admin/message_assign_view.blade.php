	<input type="hidden" name="hdn_id" value="{{$msg_id}}">
	<ul class="list-group">
		@if($users)
		<li class="list-group-item"><input class="pull-left" type="checkbox" name="ck_all" id="ck_all">&nbsp;&nbsp;Select All</li>
		@foreach ($users as $usr)
			<li class="list-group-item"><input class="pull-left ck_user" type="checkbox" value="{{$usr->id}}" name="ck_assign[]" id="ck_assign">&nbsp;&nbsp;{{$usr->user_name}}&nbsp;&nbsp;&lt;{{$usr->email}}&gt;

			<span class='pull-right'>&nbsp;<input type="checkbox" class='pull-left ck_published' name="ck_published">Published</span>
			</li>
		@endforeach
		@endif
	</ul>


<script type="text/javascript">
$(document).ready(function() {
	$('#ck_all').click(function(){
		
		if($(this).is(':checked'))
		{
			//alert('from checked');
			$('.pull-left.ck_user').attr('checked','checked');
			$('.pull-left.ck_published').attr('checked','checked');
		}
		else
		{
			//alert('from unchecked');
			$('.pull-left.ck_user').removeAttr('checked');
			$('.pull-left.ck_published').removeAttr('checked');
		}
	});
	
});
</script>