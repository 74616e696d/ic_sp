<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	  <!--[if IE 7]>
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/font-awesome-ie7.min.css">
	  <![endif]-->
	<link href="<?php echo base_url(); ?>asset/css/custom/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
	 <!--  <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen"> -->
	  <link href="<?php echo base_url(); ?>asset/admin/css/styles.css" rel="stylesheet" media="screen">
	  <script src="<?php echo base_url(); ?>asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.10.0.custom.min.js"></script>
	  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script> -->
	  <!-- HTML5 shim for IE backwards compatibility -->
	  <!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	  <![endif]-->
	  
	  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap2.min.js"></script>

</head>
<body>
	<div class="form-horizontal">
		<div class="span6">
			<input type="hidden" name="hdn_com_id" value="<?php echo $com_id; ?>">
			<div class="control-group">
				<label for="ddl_exam_cat" class="control-label">Exam Category:</label>
				<div class="controls">
					<select name="ddl_exam_cat" id="ddl_exam_cat">
						<option value="-1">Select Exam Category</option>
						<?php
						if($exam_cat)
						{
							foreach ($exam_cat as $cat) {
								echo "<option value='{$cat->id}'>{$cat->name}</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label for="ddl_subject" class="control-label">Subject:</label>
				<div class="controls">
					<select name="ddl_subject" id="ddl_subject">
						<option value="-1">Select Subject</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label for="ddl_chapter_group" class="control-label">Select Chapter Group</label>
				<div class="controls">
					<select name="ddl_chapter_group" id="ddl_chapter_group">
						<option value="-1">Select Chapter Group</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label for="ddl_chapter" class="control-label">Select Chapter:</label>
				<div class="controls">
					<select name="ddl_chapter" id="ddl_chapter">
						<option value="-1">Select Chapter</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button id='btn_search' class='btn btn-default'><i class="fa fa-search"></i>&nbsp;Search</button>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<div class="controls">
				<input type="text" class='pull-left' name="txt_q_search" id="txt_q_search" placeholder='Quick Search'>
				</div>
			</div>
			<ul class="list-group" style='overflow:auto;height:250px;'>
				
			</ul>
		</div>
		
	</div>
 <div id='loadingDiv'>
    Please wait...  <img src='<?php echo base_url(); ?>/asset/img/ajax-loader.gif' alt='' />
 </div> 
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/typeahead.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var exam_cat=$('#ddl_exam_cat'),
			subject=$('#ddl_subject'),
			chapter_group=$('#ddl_chapter_group'),
			chapter=$('#ddl_chapter');

		//start get subject by exam cat
		exam_cat.change(function() {
			var pid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/ques_to_comprehension/get_subject',
				type: 'GET',
				data: {pid:pid},
			})
			.done(function(data) {
				subject.html(data);
			});
		});
		//end get subject by exam cat
		
		//start get chapter group by exam cat
		subject.change(function() {
			var pid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/ques_to_comprehension/get_cahpter_group',
				type: 'GET',
				data: {pid:pid},
			})
			.done(function(data) {
				chapter_group.html(data);
			});
		});
		//end get chapter group by exam cat
		
		//start get chapter group by exam cat
		chapter_group.change(function() {
			var pid=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/ques_to_comprehension/get_chapter',
				type: 'GET',
				data: {pid:pid},
			})
			.done(function(data) {
				chapter.html(data);
			});
		});
		//end get chapter group by exam cat
		

		//get questions by criteria
		$('#btn_search').click(function(e){
			var subj=subject.val(),
			chap_group=chapter_group.val();
			chap=chapter.val();
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/ques_to_comprehension/ques_list',
				type:'POST',
				data: {subj:subj,chap_group:chap_group,chapter:chap},
			})
			.done(function(data) {
				$('.list-group').html(data);
			});
			
		});
		//end get questions by criteria
		
		//displaing loader image
		$('#loadingDiv').hide().ajaxStart( function() {
			$(this).show();  // show Loading Div
		} ).ajaxStop ( function(){
			$(this).hide(); // hide loading div
		});
		//end displaying loader image
		

		//auto complete
		$('#txt_q_search').keyup(function() {
			var key=$(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>admin/ques_to_comprehension/ques_auto_coomplete',
				type: 'GET',
				data: {ques:key},
			})
			.done(function(data) {
				$('.list-group').html(data);
			});
			
		});
		//end autocomplete
	});
</script>
</body>
</html>