<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<form action="<?php echo base_url(); ?>admin/exam/add" method="post">
	<label for="ddl_exam">Exam:</label>
	<select name="ddl_exam" id="ddl_exam">
		
	</select>

	<label for="ddl_subject">Subject:</label>
	<select name="ddl_subject" id="ddl_subject">
		
	</select>

	<label form="txt_details"></label>
	<?php echo $this->ckeditor->editor("txt_details",""); ?>


</form>