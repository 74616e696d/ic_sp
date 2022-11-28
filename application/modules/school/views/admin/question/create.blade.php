@extends('admin.master.master')

@section('content')
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap-tag.css">
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap-tag.js"></script>
<style>
    .control-label{width:auto !important;}
    .controls{margin-left:100px !important;}
    .multiselect-container li input[type=checkbox]
    {
        float:none !important;
    }
</style>

<fieldset class="form-horizontal input-form">
    <legend><div>Add Question</div></legend>

    <!-- message box start -->
    <div id="msg">
        <?php 
       //render_message(); 
       //$this->my_validation->display_message();
        ?>
    </div>
    <!-- message box end -->

    <!-- form start -->
	<form method="post" action="{{ $base_url }}school/admin/questions/store" enctype="multipart/form-data">      
        <span id="err_exam"></span>
        <div class="control-group">
            <label for="ddl_exam_cat" class="control-label">Exam Category:</label>
            <select name="ddl_exam_cat" id="ddl_exam_cat">
                <option value="-1">Select Exam Category</option>
                <?php if($cats){foreach ($cats as $c) {
                	$selected=$c->id==old_value('exam_cat')?'selected':'';
                	echo "<option {$selected} value='{$c->id}'>{$c->name}</option>";
                }} ?>
            </select>
        </div>
        <div class="control-group">
        <label class="control-label" for="ddl_subject">Subject:</label>
        <input type="hidden" name="hdn_subject" value="3">
        <div class="controls">
        <select name="ddl_subject" id="ddl_subject">
            <option value="-1">Select Subject</option>
             <?php
            if($subjects){
                foreach ($subjects as $sbj) 
                {

                    $selected=old_value('subject')==$sbj->id?'selected':'';
                    echo "<option {$selected} value='{$sbj->id}'>{$sbj->name}</option>";
                }
            }
            ?>
        </select>
        </div>
      </div>
        
        <div class="control-group">
        <label class="control-label" for="ddl_chapter_group">Chapter Group:</label>
        <input type="hidden" name="hdn_chapter_group" value="6">
        <div id="chptr_group" class="controls">
        <select name="ddl_chapter_group" id="ddl_chapter_group">
            <option value="-1">Select Chapter Group</option>
             <?php
                if($chapter_group){
                    foreach ($chapter_group as $cpt) {
                        $selected=old_value('chapter_group')==$cpt->id?'selected':'';
                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                    }
                }
                ?>
        </select>
        </div>
        </div>


        <div class="control-group">
        <label for="ddl_chapter" class="control-label">Chapter:</label>
        <input type="hidden" name="hdn_chapter" value="4">
        <div id='chaptr' class="controls">
          <!--   <ul class="inline"> -->
          <select name="ddl_chapter" id="ddl_chapter">
              <option value="-1">Select Chapter</option>
                  <?php
                if($chapter_group){
                    foreach ($chapters as $cpt) {
                        $selected=old_value('chapter')==$cpt->id?'selected':'';
                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                    }
                }
                ?>
          </select>
             
           <!--  </ul> -->
        </div>
        </div>
        <br/>
        <!-- left column start -->
        <div style="margin-left:0" class="span6">
        <label for="txt_ques">Question:</label>
 
        <?php echo $ci->ckeditor->editor("txt_ques","");?>

		<label>Question Options:</label>
        <?php echo $ci->ckeditor->editor("txtoptions","");?>

          <label for="txt_hints">Hints</label>
        <?php echo $ci->ckeditor->editor("txt_hints",old_value('hints'));?>
      

      </div>  <!-- left column end -->

        <!-- right column start -->
        <div class="span4">
        
        <label for="ddl_period">Period:</label>
        <select class='ddl_period' id='ddl_period'>
            <?php
            for($i=1981;$i<2031;$i++){

                $sel_period=$i==$period?'selected':'';
                echo "<option {$sel_period} value='{$i}'>{$i}</option>";
                }
             ?>
        </select>
        <label for="txt_source">Source:</label>
        <input type="text" name="txt_source" id="txt_source" placeholder="Source" value="<?php echo old_value('question_source'); ?>">
            <label for="ddl_grade">Question Grade:</label>
            <div class="ck_list">
                <ul class='inline'>
                    <li>
                    <label for='rd_easy' class='checkbox'>
                    <input id='rd_easy' <?php if(old_value('question_grade')=='1')echo 'checked'; ?> class='pull-left' type='radio' name='rd_grade' value='1'/>
                    Easy</label>
                    </li>
                     <li>
                    <label for='rd_medium' class='checkbox'>
                    <input id='rd_medium' class='pull-left' type='radio' <?php if(old_value('question_grade')=='2')echo 'checked'; ?> name='rd_grade' value='2'/>
                    Medium</label>
                    </li>
                    <li>
                    <label for='rd_tough' class='checkbox'>
                    <input id='rd_tough' class='pull-left' type='radio' name='rd_grade' <?php if(old_value('question_grade')=='3')echo 'checked'; ?> value='3'/>
                    Tough</label>
                    </li>
                </ul>
            </div>
    

        <label for="ck_display">Display:</label>
        <input type="checkbox" value="1" name="ck_display" checked id="ck_display"/><br/><br/>
        
        <label for="ck_changeable">Is Changeable:</label>
        <input type="checkbox" name="ck_changeable" id="ck_changeable" value="-1"><br/><br/>

        <label for="ck_prev">Is Previous:</label>
        <input type="checkbox" name="ck_prev" id="ck_prev" <?php if(old_value('is_prev'))echo 'checked'; ?> value="1"/><br/><br/>

        <label for="ck_has_para">Has Paragraph:</label>
        <input type="checkbox" name="ck_has_para" id="ck_has_para" <?php if(old_value('has_paragraph'))echo 'checked'; ?> value="1" /><br/><br/>
        
        <label for="txt_tag">Tags:</label>
        <p><input type="text" name="txt_tag" id="txt_tag" data-provide="tag" class="input-tag" placeholder="Write question tag" value="<?php echo old_value('tags'); ?>"></p>

         <label for="ddl_exam_name">Previous Exam:</label> 
           <p>
           <input type="hidden" name="hdn_cat" value="">
            <select name="ddl_exam_name[]" class='multiselect' multiple="multiple" id="ddl_exam_name">
                <?php if($prev_exam){

                    $old_value=old_value('exam_name');
                    foreach ($prev_exam as $pe) {
                        $selected=in_array($pe->id,explode(',',$old_value))?'selected':'';
                        echo "<option {$selected} value='{$pe->id}'>{$pe->name}</option>";
                    }  }
                 ?>
            </select>
      
            </p>
        </div>
        
        <!-- right column end -->

        <div class="clearfix"></div>
        <br/>
        <div class="btn-row">
            <button type="submit" name="btn_save" class="btn btn-info" value="1"><i class="icon-ok-circle icon-white"></i>&nbsp;Save</button>&nbsp;&nbsp;
            <button type="submit" name="btn_save_new" class="btn btn-info" value="2"><i class="icon-ok-circle icon-white"></i>&nbsp;Save &amp; New</button>&nbsp;&nbsp;
            <a href="<?php echo base_url(); ?>admin/question_bank" class="btn btn-danger" title="Cancel"><i class="icon-remove-circle icon-white"></i>&nbsp;Cancel</a>
        </div>
    </form>
    <!-- form end -->

</fieldset>
<div id="loader"></div>
@stop

@section('style')
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap-multiselect.css">

@stop

@section('script')
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/bootstrap-multiselect.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>

<script type="text/javascript">
$(document).ready(function(){

    var ddl_exam_cat=$('#ddl_exam_cat'),
    	ddl_name=$('#ddl_exam_name'),
        ddl_subject=$('#ddl_subject'),
        ddl_chapter_group=$('#ddl_chapter_group'),
        ddl_chapter=$('#ddl_chapter'),
        action_change_subject='<?php echo base_url(); ?>school/admin/questions/get_subjects',
         action_change_prev_exam='<?php echo base_url(); ?>school/admin/questions/get_prev_exam',
        action_change_chapter_group='<?php echo base_url(); ?>school/admin/questions/get_chapter_group',
        action_change_chapter='<?php echo base_url(); ?>school/admin/questions/get_chapter';

      	bindDropdownOnChange(ddl_exam_cat,ddl_subject,action_change_subject);
        bindDropdownOnChange(ddl_subject,ddl_chapter_group,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group,ddl_chapter,action_change_chapter);

       ddl_exam_cat.change(function(){
       	$eid=$(this).val();
       	$.ajax({
        	url: '<?php echo base_url(); ?>school/admin/questions/get_prev_exam',
        	type: 'POST',
        	data: {eid:$eid},
        })
        .done(function(msg) {
        		ddl_name.html(msg);
        });
       });	

        var editor=CKEDITOR.instances['txt_ques'];
        editor.on('blur',function(){

            var txt_to_match=editor.getData(),
                exam_cat=$('#ddl_exam_cat option:selected').val(),
                subj=$('#ddl_subject option:selected').val();
            
            if(subj>0)
            { 
                $.ajax({
                    url:'<?php echo base_url(); ?>school/admin/questions/find_similar_question',
                    type:'GET',
                    data:{ques:txt_to_match,subj:subj},
                    success:function(msg){
                        $('#msg').html(msg);
                    }
                });
            }
        });
        //$(document).on('change',ddl_exam_cat,function(){
        	//$('.multiselect').multiselect({enableFiltering:true,buttonWidth:'auto'});
        //});
        
        $(document).ajaxStart(function() {
            // show loader on start
            $("#loader").addClass('progress');
        }).ajaxSuccess(function() {
            // hide loader on success
            $("#loader").css('display','none');
        });

    });

  	function mselect()
    {
       $('.multiselect').multiselect({enableFiltering:true,buttonWidth:'auto'});
    }
</script>
@stop