@extends('admin_master.layout')

@section('content')
<form action="{{ $base_url }}admin/meta_tag/save" method="POST">
	<div class="form-group">
		<label for="meta_desc">Meta Description</label>
		<textarea name="meta_desc" id="meta_desc" class='form-control' style='width:90%;height:200px;'>{{ $meta->meta_desc }}</textarea>
	</div>

	<div class="form-group">
		<label for="meta_key">Meta Keyword(Comma Seperated)</label>
		<textarea name="meta_key" id="meta_key" clas='form-control' style='width:90%;height:200px;'>{{ $meta->meta_key }}</textarea>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
	</div>
</form>
@endsection