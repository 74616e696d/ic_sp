@extends('admin_master.layout')

@section('content')
<form action="{{$base_url}}admin/chapter_media/update" method="post" class="form-horizontal">
	<input type="hidden" name="hdn_id" value="{{$edit_id}}">
	<div class="control-group">
		<label for="ddl_category" class="control-label">Exam Category</label>
		<div class="controls">
			<select name="ddl_category" id="ddl_category">
				<option value="-1">Select Exam Category</option>
				@if($exams)
				@foreach ($exams as $exm)
					<option value="{{$exm->id}}">{{$exm->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="ddl_subject" class="control-label">Subject</label>
		<div class="controls">
			<select name="ddl_subject" id="ddl_subject">
				
			</select>
		</div>
	</div>

	<div class="control-group">
		<label for="ddl_chapter" class="control-label">Chapter</label>
		<div class="controls">
			<select name="ddl_chapter" id="ddl_chapter">
				<option value="-1">Select Chapter</option>
				@if($chapters)
				@foreach ($chapters as $cpt)
					<option @if($media->chapter_id==$cpt->id){{'selected'}}@endif value="{{$cpt->id}}">{{$cpt->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="control-group">
		<label for="txt_media" class="control-label">Media URL</label>

		<div class="controls">
			<!-- {{$media->media_url}} -->
			<textarea name="txt_media" id="txt_media" required='required'>{{$media->media_url}}</textarea>
		</div>
	</div>

	<div class="control-group">
		<label for="ddl_role" class="control-label">Role</label>
		<div class="controls">
			<select name="ddl_role" id="ddl_role">
				<option value="-1">Select Role</option>
				@if($members)
				@foreach($members as $mem)
					<option @if($media->role==$mem->id){{'selected'}}@endif value="{{$mem->id}}">{{$mem->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label><input style='float:left' @if($media->display){{'checked'}}@endif type="checkbox" value="1" name="ck_display" id="ck_display">&nbsp;&nbsp;Display</label>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button class="btn btn-info" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>
			<a class='btn btn-danger' href="{{$base_url}}admin/chapter_media"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
		</div>
	</div>
</form>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#ddl_category').change(function(){
			var eid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/chapter_details/get_subjects',
				type: 'POST',
				data: {eid:eid},
			})
			.done(function(data) {
				$('#ddl_subject').html(data);
			});
			
		});


		$('#ddl_subject').change(function() {
			var subj=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/chapter_details/get_chapters',
				type: 'POST',
				data: {subj:subj},
			})
			.done(function(data) {
				$('#ddl_chapter').html(data);
			});
			
		});

		$('#ddl_chapter').change(function(){

			var chapter=$(this).children(':selected').val();
			if(chapter!=-1)
			{
					$.ajax({
					url: '<?php echo base_url(); ?>admin/chapter_details/get_ref_details',
					type: 'GET',
					data: {rid:chapter},
					})
					.done(function(msg) {
						$('#dlts').html(msg);
					});
			}
		});
	});
</script>
@stop