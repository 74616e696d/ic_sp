<style>
.tab-pane
{
	padding-left:20px;
}
</style>
<div>
	<?php render_message(); ?>
	<?php $this->my_validation->display_message();?>
	<div id='int_msg'>
		
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#add" data-toggle="tab">Add Exam &nbsp;&nbsp;(Step One)</a></li>
	<li><a href="#exam_marks" data-toggle="tab">Map Exam Marks &nbsp;&nbsp;(Step Two)</a></li>
</ul>
<div class="tab-content">
<!-- tab one start -->
<div class="tab-pane fade in active" id="add">
<form class="form-horizontal" novalidate action="<?php echo base_url(); ?>admin/add_exam/add" method="post">
<label for="ddl_exam_cat">Exam Category:</label>
<select name="ddl_exam_cat" id="ddl_exam_cat">
	<option value="-1">Select Exam Category</option>
	<?php if($exam_cat){foreach ($exam_cat as $ec) { ?>
		<option value="<?php echo $ec->id; ?>"><?php echo $ec->name; ?></option>
	<?php }} ?>
</select>
<br/>

<label for="ddl_test_type">Test Type:</label>
<select name="ddl_test_type" id="ddl_test_type">
	<option value="-1">Select Test Type</option>
<!-- 	<?php if($test_types){foreach ($test_types as $tt) { ?>
		<option value="<?php echo $tt->id; ?>"><?php echo $tt->name; ?></option>
	<?php }} ?> -->

	<option value="15">Model Test</option>
	<option value="16">Previous Test</option>
</select>

<label for="txt_test_name">Test Name:</label>
<input type="text" name="txt_test_name" style="height:30px;" id="txt_test_name" required="required" placeholder="Test Name">

<label for="txt_total_ques">Total Question:</label>
<input type="text" name="txt_total_ques" id="txt_total_ques" style="width:50px;height:30px;" value="100" min="1" max="100">

<label for="txt_total_marks">Total Marks:</label>
<input type="text" name="txt_total_marks" style="width:50px;height:30px;" id="txt_total_marks" value="100" min="1" max="100">

<label for="txt_mark_carry">Marks Carry(Per Question):</label>
<input type="text" name="txt_mark_carry" style="width:50px;height:30px;" id="txt_mark_carry" value="1" min='0' max='100'>
<label for="txt_weight">Weight:</label>
<input type="text" style='width:50px;height:30px;' name="txt_weight" id="txt_weight" value="5" min='1' max='10'>
<label for="txt_neg_marks">Negative Marks:</label>
<input type="number" style='width:50px;height:30px;' name="txt_neg_marks" id="txt_neg_marks" value="0" min='0' max='1'>

<br/><br/>
<button type="submit" class="btn btn-info"><i class="icon icon-ok-circle icon-white"></i>&nbsp;Save</button>
<a href="<?php echo base_url(); ?>admin/manage_assigned_question" class="btn btn-danger"><i class="icon icon-remove-circle icon-white"></i>&nbsp;Cancel</a>
</form>
</div> <!-- tab one end -->
<!-- tab two start -->
<div class='tab-pane fade in' id="exam_marks">
	<div class="span6">
	<form action="<?php echo base_url(); ?>admin/add_exam/save_mark_mapping" method='post'>
		<label for="ddl_exam_list">Select Test:</label>
		<select name="ddl_exam_list" id="ddl_exam_list">
			<option value="-1">-Select a Test-</option>
			<?php 
			if($test_name){	foreach($test_name as $tname) {
				echo "<option value='{$tname->id}'>{$tname->test_name}</option>";
			}}?>
		</select> <button class='btn' id='btn_refresh'><i class='icon icon-refresh'></i></button>
		
		<label for="ddl_subject">Subject:</label>
		<select name="ddl_subject" id="ddl_subject">
			<option value="-1">-Select Subject-</option>
			<?php
				if($subject){foreach ($subject as $sbj){
					echo "<option value='{$sbj->id}'>{$sbj->name}</option>";
				}} 
			?>
		</select>

		<label for="ddl_chapter_group">Chapter Group:</label>
		<select name="ddl_chapter_group" id="ddl_chapter_group">
			<option value="-1">-Select Chapter Group-</option>
		</select>

		<label for="ddl_chapter">Chapter:</label>
		<select name="ddl_chapter" id="ddl_chapter">
			<option value="-1">-Select Chapter-</option>
		</select>

		<label for="txt_marks">Mark:</label>
		<input type="text" name="txt_marks" id="txt_marks" value='0' min='0' max='100'>
		<br/><br/>
		<button id='btn_mark' class='btn btn-info' type='submit'><i class='icon icon-ok-circle icon-white'></i>&nbsp;Save</button>
	</form>
	</div>
	<div id='mapping_list' class="span6">
		
	</div>
</div><!-- tab two end -->
</div>

<div id="edit_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/edit_marks_mapping/edit">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Edit  Exam Marks Mapping</h3>
  	</div>
  	<div class="modal-body" style='max-height:500px;'>
   	 <p></p>
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-info pull-left"><i class='icon icon-ok-circle icon-white'></i>Update</button>
  </div>
  </form>
	</div>

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery.cookie.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>
<script>
	$(document).ready(function() 
	{
		var subj=$('#ddl_subject'),
			chapter_group=$('#ddl_chapter_group'),
			chapter=$('#ddl_chapter'),
			action_chapter_group='<?php echo base_url(); ?>admin/add_exam/get_chapter_group',
			action_chapter='<?php echo base_url(); ?>admin/add_exam/get_chapters';

			bindDropdownOnChange(subj,chapter_group,action_chapter_group);
			bindDropdownOnChange(chapter_group,chapter,action_chapter);

		$('a[data-toggle="tab"]').on('shown', function(e){

    	//save the latest tab using a cookie:
    	$.cookie('last_tab', $(e.target).attr('href'));

    	});
    	//activate latest tab, if it exists:
    	var lastTab = $.cookie('last_tab');
    	if (lastTab) {
        	$('a[href=' + lastTab + ']').tab('show');
		}

		// displaying marks mapping list
		$('#ddl_exam_list').change(function(){
			var eid=$(this).val();
			if(eid!=-1)
			{
				$.ajax({
				url: '<?php echo base_url(); ?>admin/add_exam/mapping_list',
				type: 'GET',
				data: {exam_id:eid}
			})
			.done(function(msg) {
				$('#mapping_list').html(msg);
			});
			}
			else
			{
				$('#mapping_list').html('');
			}
		});
		//end displaying marks mapping list
		

		$('#txt_marks').blur(function(){
			var sid=subj.val(),
				mrk=$(this).val();
			if(sid>0)
			{
				var cgid=chapter_group.val(),
					cpid=chapter.val(),
					exmid=$('#ddl_exam_list').val();
				$.ajax({
				url: '<?php echo base_url(); ?>admin/add_exam/check_integrity',
				type: 'GET',
				data: {exam_id:exmid,subject:sid,chapter_group:cgid,chapter:cpid,mark:mrk}
				})
				.done(function(msg) {
					if(msg!='')
					{
						var data=msg.split('-');
						//alert(data[0]);
						if(data[0]=='1')
						{

							$('#btn_mark').attr('disabled','disabled');
						}
						
						var message="<div class='alert alert-error'>";
							message+="<button type='button' class='close' data-dismiss='alert'>&times;</button>";
							message+="<strong>"+data[1]+"</strong>";
							message+="</div>";
						$('#int_msg').html(message);
					}
					else
					{
						$('#btn_mark').removeAttr('disabled');
						$('#int_msg').html('');
					}
				});
			}
		});

		//$('#edit_dlg').modal({data-remote='<?php echo base_url(); ?>admin/edit_marks_mapping/index',data-show="true"});

		$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});

		$('#btn_refresh').click(function(e){
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/add_exam/refresh',
				type: 'POST',
			});
		});

	});
</script>

