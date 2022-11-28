@extends('admin_master.layout')

@section('content')
<div class="span-10 span-md-offset-2">
<form action="{{$base_url}}admin/post_comment/update" method="post" class="form-horizontal">
	<input type="hidden" name="hdn_id" value="{{$comment->id}}">
	<div class="control-group">
		<label for="comment" class="control-label">Comment</label>
		<div class="controls">
			<textarea name="comment" id="comment" cols="30">{{$comment->comment}}</textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class='checkbox'>
				<input type="checkbox" name="ck_display" id="ck_display" {{$comment->display?'checked':''}} value="1"> Published
			</label>
			<br><br>
			<button class="btn btn-info"><i class="fa fa-save"></i> Save</button>
			<a href="{{$base_url}}admin/post_comment" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
		</div>
	</div>
</form>
</div>
@stop