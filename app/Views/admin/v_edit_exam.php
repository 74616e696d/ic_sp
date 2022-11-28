	<div class="span7">
	<input type="hidden" name="hdn_id" value="<?php echo $exam->id; ?>">
	<label for="ddl_exam_cat">Exam Category:</label>
	<select name="ddl_exam_cat" id="ddl_exam_cat">
		<option value="-1">Select Exam Category</option>
		<?php if($exam_cat){foreach ($exam_cat as $ec) { ?>
			<option <?php if($exam->exam_cat==$ec->id)echo 'selected'; ?> value="<?php echo $ec->id; ?>"><?php echo $ec->name; ?></option>
		<?php }} ?>
	</select>


	<label for="ddl_test_type">Test Type:</label>
	<select name="ddl_test_type" id="ddl_test_type">
		<option value="-1">Select Test Type</option>
		<option <?php $sel=$exam->test_type==15?'selected':''; echo $sel; ?> value="15">Model Test</option>
		<option <?php $sel=$exam->test_type==16?'selected':''; echo $sel; ?> value="16">Previous Test</option>
	</select>

	<label for="txt_test_name">Test Name:</label>
	<input type="text" name="txt_test_name" id="txt_test_name" value='<?php echo $exam->test_name; ?>' reuired="required" placeholder="Test Name">

	<label for="txt_total_ques">Total Question:</label>
	<input type="text" name="txt_total_ques" id="txt_total_ques" style="width:50px;height:30px;" value="<?php echo $exam->total_ques; ?>" min="1" max="100">

	<label for="txt_total_marks">Total Marks:</label>
	<input type="text" name="txt_total_marks" style="width:50px;height:30px;" id="txt_total_marks" value="<?php echo $exam->total_marks; ?>" min="1" max="100">
	</div>

	<div class="span5">
		<label for="txt_mark_carry">Marks Carry(Per Question):</label>

		<input type="text" name="txt_mark_carry" style="width:50px;height:30px;" id="txt_mark_carry" value="<?php echo $exam->mark_carry; ?>" min='1' max='100'>
		
		<label for="txt_weight">Weight:</label>
		<input type="text" style='width:50px;height:30px;' name="txt_weight" id="txt_weight" value="<?php echo $exam->weight; ?>" min='1' max='10'>

		<label for="txt_total_time">Total Time</label>
		<input type="number" style='width:50px;height:30px;' name="txt_total_time" id="txt_total_time" value="<?php echo $exam->total_time; ?>" min='1' max='240'>

		<label for="txt_neg_marks">Negative Marks</label>
		<input type="number" style='width:50px;height:30px;' name="txt_neg_marks" id="txt_neg_marks" value="<?php echo $exam->negative_marks; ?>" min='0' max='1'>
	</div>







	