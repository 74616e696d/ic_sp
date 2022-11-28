@extends('admin_master.layout')

@section('content')
	
<form action="{{$base_url}}admin/vocabulary/update" method="post" class="form-horizontal">
<input type="hidden" name="hdn_id" value="{{$item->id}}">
	<div class="control-group">
		<label for="word" class="control-label">Word:</label>
		<div class="controls">
			<input type="text" name="word" id="word" value="{{$item->word}}" required='required'>
		</div>
	</div>

	<div class="control-group">
		<label for="meaning" class="control-label">Meaning</label>
		<div class="controls">
			<input type="text" name="meaning" id="meaning" value="{{$item->meaning}}">
		</div>
	</div>

	<div class="control-group">
		<label for="syn" class="control-label">Synonyms:</label>
		<div class="controls">
			<input type="text" name="syn" id="syn" value="{{$item->synonyms}}">
		</div>
	</div>

	<div class="control-group">
		<label for="antonym" class="control-label">Antonyms:</label>
		<div class="controls">
			<input type="text" name="antonym" id="antonym" value="{{$item->antonyms}}">
		</div>
	</div>

	<div class="control-group">
		<label for="example" class="control-label">Example</label>
		<div class="controls">
			<textarea name="example" id="example" cols="30" rows="10">{{$item->example}}</textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" {{$item->display?'checked':''}} name="display" id="display" value="1"> Display
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<button class="btn btn-info" type="submit"><i class="fa fa-save"></i> Update</button>
		</div>
	</div>
</form>

@stop

@section('style')
@stop

@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
	});
</script>
@stop