<div><?php render_message(); ?></div>
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<form class="form-horizontal" action="<?php echo base_url(); ?>admin/chapter_details/add" method="post">
	<div class="form-inline">
	<label for="ddl_exam_cat">Exam Category:</label>
	<select name="ddl_exam_cat" id="ddl_exam_cat">
		<option value="-1">Select Exam Category</option>
		<?php 
		if($exams)
		{
			foreach ($exams as $e) {
				echo "<option value='{$e->id}'>{$e->name}</option>";
			}
		}
		?>
	</select>
	<label for="ddl_subject">Subject:</label>
	<select name="ddl_subject" id="ddl_subject">
		
	</select>
	<label for="ddl_chapter">Chapter:</label>
	<select name="ddl_chapter" id="ddl_chapter">
		<option value="-1">Select Chapter</option>
		<?php if($chapters){foreach ($chapters as $cp) {?>
			<option value="<?php echo $cp->id;?>"><?php echo $cp->name; ?></option>
		<?php }} ?>
	</select>
	</div>
	<br>
	<div id="dlts">
		<label for="txt_tips">Hot Tips:</label>
	<div>
		<?php echo $this->ckeditor->editor("txt_tips","",array('width'=>'70%')); ?>
	</div>
	<br>
	<label for="txt_details">Details:</label>
		 <?php echo $this->ckeditor->editor("txt_details","");?>
	</div>
	<br/>
	 <button type="submit" class="btn btn-info"><i class="icon icon-ok-circle icon-white"></i>&nbsp;&nbsp;&nbsp;Save</button>
</form>
		
<script type="text/javascript">
	$(document).ready(function() {

		$('#ddl_exam_cat').change(function(){
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
