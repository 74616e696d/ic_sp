@extends('admin_master.layout')

@section('content')

<div class="row">
	<form action="{{ $base_url }}admin/news/create" method="post" class="form-horizontal">
		<div class="control-group">
			<label for="job_category" class="control-label">Job Category</label>
			<div class="controls">
				<select name="job_category" id="job_category">
					<option value="">-Select Job Category-</option>
					@if($categories)
						@foreach($categories as $cat)
						<option value="{{ $cat->id }}">{{ $cat->title }}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="control-group">
			<label for="txt_title" class="control-label">Job Title</label>
			<div class="controls">
				<input type="text" name="txt_title" id="txt_title" required='required'>
			</div>
		</div>

		<div class="control-group">
			<label for="post_name" class="control-label">Post Name</label>
			<div class="controls">
				<input type="text" name="post_name" id="post_name">
			</div>
		</div>

		<div class="control-group">
			<label for="txt_details" class="control-label">Details</label>
			<div class="controls">
				<textarea name="txt_details" id="txt_details"></textarea> 
			</div>
		</div>

		<div class="control-group">
			<label for="link" class="control-label">Link</label>
			<div class="controls">
				<input type="text" name="link" id="link">
			</div>
		</div>
		
		<div class="control-group">
			<label for="link_text" class="control-label">Company Logo</label>
			<div class="controls">
				<img width="50" id='logo_img' src="" alt="No Logo"> <br>
				<input type="text" name="logo" id="logo"> 	<a href="{{$base_url}}admin/news/pick_files" data-target="#myModal" role="button" class="btn" data-toggle="modal"><i class="fa fa-picture-o"></i></a>
			</div>
		</div>

		<div class="control-group">
			<label for="link_text" class="control-label">Link Text</label>
			<div class="controls">
				<input type="text" name="link_text" id="link_text">
			</div>
		</div>

		<div class="control-group">
			<label for="txt_pub_date" class='control-label'>Publish Date</label>
			<div class="controls">
				<input type="text" name="txt_pub_date" id="txt_pub_date" class="dt">
			</div>
		</div>

		<div class="control-group">
			<label for="deadline" class='control-label'>Deadline</label>
			<div class="controls">
				<input type="text" name="deadline" id="deadline" class="dt">
			</div>
		</div>

		<div class="control-group">
			<label for="location" class="control-label">Location</label>
			<div class="controls">
				<select name="location" id="location">
					@if($district)
					@foreach($district as $dis)
					<option value="{{ $dis->FIELD2 }}">{{ $dis->FIELD2 }}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="tags" class="control-label">Tags</label>
			<div class="controls">
				<textarea name="tags" id="tags"></textarea>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="ck_display" id="ck_display" value="1">Display
				</label>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="is_featured" id="ck_display" value="1">Is Featured
				</label>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-default">Create</button>
				<a href="{{$base_url}}admin/news/news_list" class="btn btn-danger">
				<i class="fa fa-times-circle"></i> Cancel</a>
			</div>
		</div>


	</form>
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Select Company Logo</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/select2/select2.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/select2/select2-bootstrap.css">
<style>
	.select2-container
	{
		width: 220px;
	}
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{{ $base_url }}asset/vendor/select2/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace('txt_details');
		CKEDITOR.config.width="450";
		$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});


		$('#myModal').on('shown', function () {
		 	$(this).removeData('.modal');
		});
		
		$(document).on("click", "#myModal a.thumbnail", function (e) {
			e.preventDefault();
			var logo=$(this).data('img');
			var logo_path='{{$base_url}}asset/job/'+logo;
			$('#logo_img').attr('src',logo_path);
			$('#logo').val(logo);
			$('#myModal').modal('hide');
		});

		//select 2
		$('#location').select2();
		//end select 2

	});

	
</script>
@stop