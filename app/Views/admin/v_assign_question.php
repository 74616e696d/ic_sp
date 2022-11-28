<div>
    <?php render_message(); ?>
</div>
 <div id='loader'>
    <img src="<?php echo base_url(); ?>asset/img/loader.gif" alt="loading...">
</div>
	<div class="span6">
		<fieldset>
			<legend>Search</legend>
		
		<label>Exam Category:</label>
		  <div class='ck_list'>
            <ul class='inline'>
                 <?php
                if($cats){ foreach ($cats as $c) {
                    echo "<li><label for='ck_cat_{$c->id}' class='checkbox'>
                    <input class='ck_cat' id='ck_cat_{$c->id}' type='checkbox' name='ck_cat[]' value='{$c->id}'/>{$c->name}</label></li>";
                }}
                 ?>
            </ul>
        </div>
        <br/>
        <div id='exam_name_div' class='ck_list'>
        	
        </div>
	
		<label >Subject:</label>
        <input type="hidden" name="hdn_subject" value="3">
        <div id="subj" class="ck_list">
        <ul class="inline">
            <?php
            if($subjects){
                foreach ($subjects as $sbj) {
                   echo "<li><label for='ck_subj_{$sbj->id}' class='checkbox'>
                    <input class='ck_subj' id='ck_subj_{$sbj->id}' type='checkbox' name='ck_subj[]' value='{$sbj->id}'/>{$sbj->name}</label></li>";
                }
            }
            ?>
        </ul>
        </div>

         <label>Chapter Group:</label>
        <input type="hidden" name="hdn_chapter_group" value="6">
        <div id="chptr_group" class="ck_list">
            <ul class="inline">
            <?php
                if($chapter_group){
                    foreach ($chapter_group as $cpt) {
                       echo "<li><label for='ck_chapter_group_{$cpt->id}' class='checkbox'>
                        <input class='ck_chapter_group' id='ck_chapter_group_{$cpt->id}' type='checkbox' name='ck_chapter_group[]' value='{$cpt->id}'/>{$cpt->name}</label></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <label for="ddl_chapter">Chapter:</label>
        <input type="hidden" name="hdn_chapter" value="4">
        <div id='chaptr' class="ck_list">
            <ul class="inline">
                 <?php
                if($chapter_group){
                    foreach ($chapters as $cpt) {
                       echo "<li><label for='ck_chapter_{$cpt->id}' class='checkbox'>
                        <input class='ck_chapter' id='ck_chapter_{$cpt->id}' type='checkbox' name='ck_chapter[]' value='{$cpt->id}'/>{$cpt->name}</label></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <br/>
        <div class="ck_list">
        	<label class="checkbox"><input style="margin-left:7px;" type="checkbox" name="ck_is_prev" id="ck_is_prev" value="1">Is Previous</label>
		</div>
        <label id="lblSearch" class="btn btn-info"><i class='icon icon-search icon-white'></i>&nbsp;&nbsp;Search</label>
        </fieldset>
	</div>
	<div class="span4">
    <form class="form-horizontal" action="<?php echo base_url(); ?>admin/assign_question/assign" method="post">
     
        <br/><br/>
		<label for="ddl_test_type">Test Type:</label>
		<select name="ddl_test_type" id="ddl_test_type">
            <option value="-1">Select Test Type</option>     
            <?php if($test_type){foreach ($test_type as $tt) { ?>
                <option value="<?php echo $tt->id; ?>"><?php echo $tt->test_name; ?></option>
           <?php }} ?> 
        </select>
        <br/><br/>

		<!-- <input type="text" name="txt_exam_name" id="txt_exam_name" required="required" placeholder="test name"> -->
        <div id="q_lst" class="ck_list">
            
        </div>
        <button type="submit" class="btn btn-info"><i class="icon icon-ok-circle icon-white"></i>Save</button>
        </form>
	</div>
   

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>
<script>
	$(document).ready(function() {
		  var exam_cat=$('.ck_cat'),
            ddl_cat=$('#ddl_exam_cat'),
            ddl_tt=$('#ddl_test_type'),
            exam_name=$('#exam_name_div'),
            ck_exam_name=$('.ck_exam_name_'),
            ck_subj=$('.ck_subj'),
            chapter_group=$('.ck_chapter_group'),
            chapter=$('.ck_chapter'),
            //action_change_exam_name='<?php echo base_url(); ?>admin/add_question/exam_by_cat',
            action='<?php echo base_url(); ?>admin/add_question/generate_exam_name',
            bind_test_type_action='<?php echo base_url(); ?>admin/assign_question/get_tt';

        exam_meta_on_ck_change(exam_cat,exam_name,action);
        //exam_meta_on_ck_change(ck_name,subj,action);
        bindDropdownOnChange(ddl_cat,ddl_tt,bind_test_type_action);

        $('#lblSearch').click(function(){
            var cat_arr=[],
                exam_name_arr=[],
                subj_arr=[],
                chapter_group_arr=[],
                chapter_arr=[],
                is_prev=$('#ck_is_prev').is(':checked')?'1':'';

            $.each(exam_cat, function() {
                if($(this).is(':checked')){
                cat_arr.push($(this).val());
                }
            });

            $.each(ck_exam_name, function() {
                if($(this).is(':checked')){
                exam_name_arr.push($(this).val());
                }
            });

             $.each(ck_subj, function() {
                if($(this).is(':checked')){
                subj_arr.push($(this).val());
                }
            });

            $.each(chapter_group, function() {
                if($(this).is(':checked')){
                chapter_group_arr.push($(this).val());
                }
            });

            $.each(chapter, function() {
                if($(this).is(':checked')){
                chapter_arr.push($(this).val());
                }
            });
            //alert(subj_arr);
            $.ajax({
                url: '<?php echo base_url(); ?>admin/assign_question/get_ques_list',
                type: 'GET',
                data:{cat:cat_arr.toString(),exam:exam_name_arr.toString(),
                    subj:subj_arr.toString(),chapter_group:chapter_group_arr.toString(),
                    chapter:chapter_arr.toString(),prev:is_prev.toString()}
            })
            .done(function(msg) {
                $('#q_lst').html(msg);

            });

        });


        $(document).on('click','#ck_all_ques',function(){
            if($(this).is(':checked'))
            {
                $('.ck_ques').attr('checked','checked');
                var totalQues=$(".ck_ques:checked").length;
                $('#ttl').html(totalQues);
            }
            else
            {
                $('.ck_ques').removeAttr('checked');
                 var totalQues=$(".ck_ques:checked").length;
                $('#ttl').html(totalQues);
            }
        });

        $(document).on('click','.ck_ques',function(){
                var totalQues=$(".ck_ques:checked").length;
                $('#ttl').html(totalQues);
        });


        $('#loader').hide().ajaxStart(function(){
            $(this).show();
            }).ajaxStop(function() {$(this).hide(); });

	});
</script>