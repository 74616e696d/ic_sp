@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/current_news/update" enctype="multipart/form-data">

	<div class="span7">
		<input type="hidden" name="hdn_id" value="{{$news->id}}">
		<div class="control-group">
			<label for="ddlCategory" class="control-label">Category</label>
			<div class="controls">
				<select name="ddlCategory" id="ddlCategory">
					<option value="">Select Category</option>
					@if($category)
					@foreach($category as $cat)
					<option {{$news->category_id==$cat->id?'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="txtTitle" class="control-label">Title</label>
			<div class="controls">
				<input type="text" name="txtTitle" id="txtTitle" required value="{{$news->title}}">
			</div>
		</div>

		<div class="control-group">
			<label for="txtShortDetails" class="control-label">Short Description</label>
			<div class="controls">
				<textarea name="txtShortDetails" id="txtShortDetails" required>{{$news->short_desc}}</textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="txtDetails" class="control-label">description</label>
			<div class="controls">
				<textarea name="txtDetails" id="txtDetails" required>{{$news->details}}</textarea>
			</div>
		</div>
	</div>
	
	<div class="span5">
		<div class="control-group">
			<label for="txtTags" class="control-label">Tags</label>
			<div class="controls">
				<textarea name="txtTags" id="txtTags">{{$news->tags}}</textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="txt_meta_desc" class="control-label">Meta Description</label>
			<textarea name="txt_meta_desc" id="txt_meta_desc">{{ $news->meta_desc }}</textarea>
		</div>
		<div class="control-group">
			<label for="txt_meta_tags" class="control-label">Meta Keywords</label>
			<textarea name="txt_meta_tags" id="txt_meta_tags">{{ $news->meta_keyword }}</textarea>
		</div>
		
		<div class="control-group">
			<label for="userfile" class="control-label">Feature Image</label>
			<div class="controls">
				@if(!empty($news->feature_img))
				<img width="150" src="{{$base_url}}asset/news/{{$news->feature_img}}" alt="">
				<br>
				@endif
				<input type="hidden" name="hdn_img" id="hdn_img">
				<input type="hidden" name="hdn_current_img" id="hdn_current_img"  value="{{$news->feature_img}}">
				<input type='file' name="userfile" id="userfile">
			</div>
		</div>
		<div class="control-group">
			<label for="" class="control-label">Published Date</label>
			<div class="controls">
			{{date_picker('pulished_date',$news->post_date)}}
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<label class='checkbox'>
					<input type="checkbox" name="display" id="display" value="1" {{$news->display?'checked':''}}>  Display
				</label>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<label class='checkbox'>
					<input {{ $news->is_featured?'checked':'' }} type="checkbox" name="is_featured" id="is_featured" value="1">  Is Featured
				</label>
			</div>
		</div>
	</div>

	<div class="span12">
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
				<a href="{{$base_url}}admin/current_news" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
			</div>
		</div>
	</div>
	
</form>
@stop


@section('style')
<style>
.dt
{
	width:80px;
	margin-right:10px;
}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace('txtDetails');
	CKEDITOR.replace('txtShortDetails');
	$('#userfile').change(function() {
		var img=$(this).val();
		$('#hdn_img').val(img);
	});
});
</script>
@stop