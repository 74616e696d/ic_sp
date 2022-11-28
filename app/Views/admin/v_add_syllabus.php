<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<div>
	<?php render_message();
		$this->my_validation->display_message();
	 ?>
</div>
<form action="<?php echo base_url(); ?>admin/add_syllabus/add" method="post">
	<label for="ddl_exam">Exam:</label>
	<select name="ddl_exam" id="ddl_exam">
		<option value="-1">Select Exam</option>
		<?php if($exams){foreach ($exams as $e){ ?>
			<option value="<?php echo $e->id;  ?>"><?php echo $e->name; ?></option>
		<?php }} ?>
	</select>

	<label for="ddl_subject">Subject:</label>
	<select name="ddl_subject" id="ddl_subject">
		<option value="-1">Select Subject</option>
		<?php if($subjects){foreach ($subjects as $sb){ ?>
			<option value="<?php echo $sb->id;  ?>"><?php echo $sb->name; ?></option>
		<?php }} ?>
	</select>

	<label form="txt_details"></label>
	<?php echo $this->ckeditor->editor("txt_details",""); ?>
	<br/>
	<label class="checkbox"><input type="checkbox" value="1" style="margin-left:0;" name="ck_display" id="ck_display">Display</label>
	<br/><br/>
	<button type="submit" class="btn btn-info"><i class="icon icon-ok-circle icon-white"></i>&nbsp;&nbsp;Save</button>
</form>