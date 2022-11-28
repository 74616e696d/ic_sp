		<label for="ddl_exam_list">Select Test:</label>
		<select name="ddl_exam_list" id="ddl_exam_list">
			<option value="-1">-Select a Test-</option>
			<?php 
			if($test_name){	foreach($test_name as $tname) {
				echo "<option value='{$tname->id}'>{$tname->test_name}</option>";
			}}?>
		</select>
		
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
	