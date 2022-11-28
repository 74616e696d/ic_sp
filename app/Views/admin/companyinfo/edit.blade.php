@extends('admin_master.layout')

@section('content')
<form method="post" action="{{ $base_url }}admin/company_info/update" class="form-horizontal">
	<input type="hidden" name="hdn_id" value="{{ $company->id }}">
	<div class="control-group">
		<label for="txt_company_name" class="control-label">Company Name</label>
		<div class="controls">
			<input type="text" name="txt_company_name" id="txt_company_name" value="{{ $company->company_name }}">
		</div>
	</div>

	<div class="control-group">
		<label for="txt_email" class="control-label">Email</label>
		<div class="controls">
			<input type="email" name="txt_email" id="txt_email" value="{{ $company->email }}">
		</div>
	</div>

	<div class="control-group">
		<label for="txt_web" class="control-label">Web</label>
		<div class="controls">
			<input type="text" name="txt_web" id="txt_web" value="{{ $company->web }}">
		</div>
	</div>

	<div class="control-group">
		<label for="txt_address" class="control-label">Address</label>
		<div class="controls">
			<textarea name="txt_address" id="txt_address">{{ $company->address }}</textarea>
		</div>
	</div>

	<div class="control-group">
		<label for="txt_logo" class="control-label">Logo</label>
		<div class="controls">
			<input type="text" name="txt_logo" id="txt_logo" value="{{ $company->logo }}">
			<a href="{{$base_url}}admin/news/pick_files" data-target="#myModal" role="button" class="btn" data-toggle="modal"><i class="fa fa-picture-o"></i></a>
		</div>
	</div>

	<div class="control-group">
		<label for="ck_active" class="control-label">Is Active</label>
		<div class="controls">
			<input type="checkbox" name="ck_active" id="ck_active" value="1" {{ $company->active?'checked':'' }}>
		</div>
	</div>
	<div class="control-group">
		<label for="ck_active" class="control-label"></label>
		<div class="controls">
			<button type="submit" class='btn btn-primary'><i class="fa fa-save"></i> Update</button>
			<a href="{{ $base_url }}admin/company_info" class='btn btn-danger'><i class="fa fa-times"></i> Cancel</a>
		</div>
	</div>

</form>

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
<link rel="stylesheet" href="{{$base_url}}asset/vendor/dropzone/dropzone.css">
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/vendor/dropzone/dropzone.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#myModal').on('shown', function () {
		$(this).removeData('.modal');
	});
	$(document).on("click", "#myModal a.thumbnail", function (e) {
		e.preventDefault();
		var logo=$(this).data('img');
		var logo_path='{{$base_url}}asset/job/'+logo;
		$('#logo_img').attr('src',logo_path);
		$('#txt_logo').val(logo_path);
		$('#myModal').modal('hide');
	});
});


function reload_files()
{
	$.ajax({
		url: '{{$base_url}}admin/news/reload_files',
		type: 'GET'
	})
	.done(function(res) {
		$('#myModal .file-box').html(res);
	});
}
</script>
@stop