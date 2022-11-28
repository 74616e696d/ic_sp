 <style>
.list-group-item
{
	padding-left:25px;
}

.list-group
{
	overflow-y:scroll;
	max-height:600px;
}
</style>
 <div id='loader'>
    <img src="<?php echo base_url(); ?>asset/img/loader.gif" alt="loading...">
</div>

   <!-- message box start -->
    <div id="msg">
        <?php 
       render_message(); 
       $this->my_validation->display_message();
        ?>
    </div>
    <!-- message box end -->
<div>
<div class="container">
<form method="post" action="<?php echo base_url(); ?>admin/question_assignment/assign">
	<div class="span6">
	<div class="form-horizontal">
		<div class="control-group">
			<label for="" class="control-label">Test Name:</label>
			<div class="controls">
				<select name="ddl_test_name" id="ddl_test_name">
					<option value="-1">Select Test Name</option>
					<?php 
						if($exams)
						{
							foreach ($exams as $exm) 
							{
								if(empty($exm->ref_id))
								{
									echo "<option value='{$exm->id}'>{$exm->test_name}</option>";
								}
								else
								{
									$testname=ref_text_model::get_text($exm->ref_id);
									echo "<option value='{$exm->id}'>{$testname}</option>";
								}
							}
						}
					?>
					</select>
					<input type="hidden" name="hdn_eid" id='hdn_eid'>
					<button id='btnRefesh' title='Refresh Assigned Question' class="btn btn-info ttp"><i class="fa fa-refresh"></i></button>
				</div>
			</div>
		</div>

		<div id="topics">
					
		</div>

	</div>
	<div class="span6">
	<input type="hidden" id='hdn_selected_topics' name="hdn_selected_topics">
		<div id="questions">
			
		</div>
	</div>

<!-- 	<div class="clear-fix">
		<button type="submit">
			<i class='icon icon-ok-circle'></i>
			Save
		</button>
	</div> -->
</form>
</div>

</div>


<script>
	$(document).ready(function() {

		$('#btnRefesh').tooltip('toggle');
		$('#ddl_test_name').change(function(){
			var exam_id=$(this).val();
			$('#hdn_eid').val(exam_id);
			$.ajax({
				url: '<?php echo base_url(); ?>admin/question_assignment/get_topics',
				type: 'GET',
				data: {exam_id: exam_id}
			})
			.done(function(msg) {
				$('#topics').html(msg);
			});
			
		});


	//get subject wise question
	$(".sbj").live('click',function(){
		var sbj=$(this).data('val'),
			eid=$("#ddl_test_name option:selected").val();

		$('#hdn_selected_topics').val(sbj);
		$.ajax({
			url: '<?php echo base_url(); ?>admin/question_assignment/question_list_by_subject',
			type: 'GET',
			data: {sbj_id:sbj,exam_id:eid},
		})
		.done(function(msg) {
			$('#questions').html(msg);
		});
		
	});//end get subject wise question

	//get chapter-group wise question
	$(".cpt-group").live('click',function(){
		var cg=$(this).data('val'),
			eid=$("#ddl_test_name option:selected").val();
		$('#hdn_selected_topics').val(cg);
		$.ajax({
			url: '<?php echo base_url(); ?>admin/question_assignment/question_list_by_chapter_group',
			type: 'GET',
			data: {cg_id:cg,exam_id:eid},
		})
		.done(function(msg) {
			$('#questions').html(msg);
		});
		
	});//end get chapter-group wise question


	//get chapter wise question
	$(".cpt").live('click',function(){
		var cpt=$(this).data('val'),
			eid=$("#ddl_test_name option:selected").val();
		$('#hdn_selected_topics').val(cpt);
		$.ajax({
			url: '<?php echo base_url(); ?>admin/question_assignment/question_list_by_chapter',
			type: 'GET',
			data: {cptr:cpt,exam_id:eid},
		})
		.done(function(msg) {
			$('#questions').html(msg);
		});
		
	}); //end get chapter wise question

	$('#questions').on('click','#check_all',function(){

			var present=$('#check_all');
				//alert(present.is(':checked'));
		if(present.is(':checked'))
		{
			$('.ck').attr('checked','checked');
			var totalQues=$(".ck:checked").length;
        	$('#ck_sel').html(totalQues);
			$('.ck').parent('label').parent('li').css('background','#DAE6F1');
		}
		else
		{
			$('.ck').removeAttr('checked');
			var totalQues=$(".ck:checked").length;
        	$('#ck_sel').html(totalQues);
			$('.ck').parent('label').parent('li').css('background','#fff');
		}
	});

	$('.ck').live('click',function(){
		var present=$(this);
		var totalQues=$(".ck:checked").length;
        $('#ck_sel').html(totalQues);
		if(present.is(':checked'))
		{
			present.parent('label').parent('li').css('background','#DAE6F1');
		}
		else
		{
			present.parent('label').parent('li').css('background','#fff');
		}
	});

	//refres question assignment
	$('#btnRefesh').click(function(e)
	{
		e.preventDefault();
		var eid=$('#hdn_eid').val();
		$.ajax({
			url: '<?php echo base_url(); ?>admin/question_assignment/refresh',
			type: 'POST',
			data:{eid:eid}
		});
		
	});

	//loader start
	 $('#loader').hide().ajaxStart(function(){
            $(this).show();
            }).ajaxStop(function() {$(this).hide(); }); //loader stop

	});
</script>