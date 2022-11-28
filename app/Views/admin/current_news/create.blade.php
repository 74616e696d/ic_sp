@extends('admin_master.layout')

@section('content')
<form method="post" action="{{$base_url}}admin/current_news/store"enctype="multipart/form-data">
	<div class="span7">
		<div class="control-group">
			<label for="ddlCategory" class="control-label">Category</label>
			<div class="controls">
				<select name="ddlCategory" id="ddlCategory">
					<option value="">Select Category</option>
					@if($category)
					@foreach($category as $cat)
					<option value="{{$cat->id}}">{{$cat->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="txtTitle" class="control-label">Title</label>
			<div class="controls">
				<input type="text" name="txtTitle" id="txtTitle" style='width:96%;' required>
			</div>
		</div>

		<div class="control-group en-lang">
			<label for="txtTitleEn" class="control-label">Title(English)</label>
			<div class="controls">
				<input type="text" name="txtTitleEn" id="txtTitleEn" style='width:96%;' required>
			</div>
		</div>

		<div class="control-group">
			<label for="txtShortDetails" class="control-label">Short Description(Bangla)</label>
			<div class="controls">
				<textarea name="txtShortDetails" id="txtShortDetails" required></textarea>
			</div>
		</div>
		<div class="control-group en-lang">
			<label for="txtShortDetailsEn" class="control-label">Short Description(English)</label>
			<div class="controls">
				<textarea name="txtShortDetailsEn" id="txtShortDetailsEn" required></textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="txtDetails" class="control-label">Description(Bangla)</label>
			<div class="controls">
				<textarea name="txtDetails" id="txtDetails"></textarea>
			</div>
		</div>

		<div class="control-group en-lang">
			<label for="txtDetailsEn" class="control-label">Description(English)</label>
			<div class="controls">
				<textarea name="txtDetailsEn" id="txtDetailsEn"></textarea>
			</div>
		</div>
	</div>
	<div class="span5">
		<div class="control-group">
			<label for="txtTags" class="control-label">Tags(use comma seperated value)</label>
			<div class="controls">
				<textarea name="txtTags" id="txtTags"></textarea>
			</div>
		</div>

		<div class="control-group">
			<label for="txtTagsEn" class="control-label">Tags English(use comma seperated value)</label>
			<div class="controls">
				<textarea name="txtTagsEn" id="txtTagsEn"></textarea>
			</div>
		</div>

	<div class="control-group">
		<label for="txt_meta_desc" class="control-label">Meta Description</label>
		<textarea name="txt_meta_desc" id="txt_meta_desc">BCS & Bank Job Preparation provided by Iconpreparation. Best website for BCS Exam and best website for Bank Job Preparation. All BCS starting from 10th to 40th Questions and solutions are available here. People can study all materials and take model tests for BCS & Bank Job Preparation. Banks job questions and solutions are also available here. Expert instructors are there to support the candidates to make an excellent preparation for job.</textarea>
	</div>
	<div class="control-group">
		<label for="txt_meta_tags" class="control-label">Meta Keywords</label>
		<textarea name="txt_meta_tags" id="txt_meta_tags">41st BCS, 40th BCS, All BCS questions and solutions, 40th BCS questions and solutions, Bank questions and solutions, Bank jobs in Bangladesh, Bangladesh Bank AD questions and solutions, Bangladesh Bank job questions, Bank job questions, BCS written, Android app for Bank job, Android App for BCS, Current Affairs, Exim Bank questions and solutions, Agrani Bank Questions 2015, Trust Bank Questions, Sonali Bank Questions and Solutions, General Knowledge for BCS, Computer Questions for Bank Jobs, Pubali Bank Questions and Solutions, Krishi Bank Questions and Solutions, Bank Job questions, BCS Model Test,BCS, NTRCA, Bank Job, Bank recruitment, Bangladesh gov't Job, PSC Job, Bangladesh Judicial Service, BCS Question Bank, Bank Question, Bank Job Question, BCS question and solution, BCS exam, BCS Preliminary, BCS written, Bank Job question and solutions, NTRCA question, NTRCA question and solution, PSC question, Engineering Job question, NTRCA Model Test, How to prepare for BCS, How to Prepare for NTRCA, How to Prepare for Bank Job</textarea>
	</div>
		
		<div class="control-group">
			<label for="" class="control-label">Feature Image</label>
			<div class="controls">
			<input type="file" name="userfile" id="userfile">
			</div>
		</div>

		<div class="control-group">
			<label for="" class="control-label">Published Date</label>
			<div class="controls">
			{{date_picker('pulished_date')}}
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<label class='checkbox'>
					<input type="checkbox" name="display" id="display" value="1">  Display
				</label>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<label class='checkbox'>
					<input type="checkbox" name="is_featured" id="is_featured" value="1">  Is Featured
				</label>
			</div>
		</div>
	</div>
	
	<div class="span12">
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
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
	width:70px;
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
		CKEDITOR.replace('txtDetailsEn');
		CKEDITOR.replace('txtShortDetailsEn');
	});
</script>
@stop