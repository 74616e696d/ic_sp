@extends('layout.layout')


@section('content')
{{Form::open(array('route'=>array('send'),'class'=>'form-horizontal'))}}
<div class="control-group">
	<label for="" class="control-label">User Group</label>
	<div class="controls">
		{{Form::select('mtp',$mtype,'',array('class'=>'form-control','id'=>'ddl_mtype'))}}
	</div>
</div>

<div class="control-group">
	<label for="title" class="control-label">Title</label>
	<div class="controls">
		<input type="text" class='form-control' name="title" id="title">
	</div>
</div>
<div class="control-group">
	<label for="body" class="control-label">Body</label>
	<div class="controls">
		<textarea name="body" id="body" class='control-label' cols="30" rows="10"></textarea>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button type="submit" name='btn_send' class='btn btn-info'>
			<i class="fa fa-mail-forward"></i> Send
		</button>
	</div>
</div>
{{Form::close()}}
@stop


@section('script')
<script type="text/javascript" src="http://iconpreparation.com/asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace('body');

});
</script>
</script>
@stop