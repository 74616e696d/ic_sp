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
    <legend><div>Edit Question</div></legend>

    <!-- message box start -->
    <div id='msg'>
        <?php echo render_message(); ?>
    </div>
    <!-- message box end -->

    <!-- form start -->
    <?php echo form_open_multipart(base_url()."admin/edit_question/update_question");?>
        <input type="hidden" name="hdn_edit_id" id="hdn_edit_id" value="<?php echo $edit_id; ?>">
        
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
                    $selected=$sbj_val==$sbj->id?'selected':'';
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
                        $selected=$chapter_group_val==$cpt->id?'selected':'';
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
                        $selected=$chapter_val==$cpt->id?'selected':'';
                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                    }
                }
                ?>
          </select>
             
           <!--  </ul> -->
        </div>
        </div>

      <!--   <label>Exam Name(If Previous):</label>
        <input type="hidden" name="hdn_cat" value="">
        <div class='ck_list'>
            <ul class='inline'>
                 <?php
                if($cats){ foreach ($cats as $c) {
                    $cked=in_array($c->id,$exam_name_val)?'checked':'';
                    echo "<li><label for='ck_exam_name_{$c->id}' class='checkbox'>
                    <input class='ck_exam_name' id='ck_exam_name_{$c->id}' type='checkbox' {$cked} name='ck_exam_name[]' value='{$c->id}'/>{$c->name}</label></li>";
                }}
                 ?>
            </ul>
        </div> -->
        <br/>
        <!-- left column start -->
        <div style="margin-left:0" class="span6">
        <label for="txt_ques">Question:</label>
        <?php echo $this->ckeditor->editor("txt_ques","{$ques->question}"); ?>

        <label>Question Options:</label>
        <?php echo $this->ckeditor->editor("txtoptions","{$ques->options}"); ?>

       <label for="txt_hints">Hints</label>
        <?php echo $this->ckeditor->editor("txt_hints","{$ques->hints}"); ?>

       
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
        <input type="text" name="txt_source" id="txt_source" placeholder="Source" value="<?php $ques->question_source; ?>">

            <label for="ddl_grade">Question Grade:</label>
            <div class="ck_list">
                <ul class='inline'>
                    <li>
                    <label for='rd_easy' class='checkbox'>
                    <input id='rd_easy' class="pull-left" <?php echo $ques->question_grade==1?'checked':''; ?> type='radio' name='rd_grade' value='1'/>
                    Easy</label>
                    </li>
                     <li>
                    <label for='rd_medium' class='checkbox'>
                    <input id='rd_medium' class="pull-left" <?php echo $ques->question_grade==2?'checked':''; ?> type='radio' name='rd_grade' value='2'/>
                    Medium</label>
                    </li>
                    <li>
                    <label for='rd_tough' class='checkbox'>
                    <input id='rd_tough' class="pull-left" <?php echo $ques->question_grade==3?'checked':''; ?> type='radio' name='rd_grade' value='3'/>
                    Tough</label>
                    </li>
                </ul>
            </div>

        <label for="ck_display">Display:</label>
        <input type="checkbox" value="1" <?php echo $ques->display?'checked':''; ?> name="ck_display" id="ck_display"/><br/><br/>

        <label for="ck_changeable">Is Changeable:</label>
        <input type="checkbox" name="ck_changeable" <?php echo $ques->is_changeable?'checked':''; ?> id="ck_changeable" value="1"><br/><br/>
    
        <label for="ck_prev">Is Previous:</label>
        <input type="checkbox" name="ck_prev" <?php echo $ques->is_prev?'checked':''; ?> id="ck_prev" value="1"/><br/><br/>

        <label for="ck_has_para">Has Paragraph:</label>
        <input type="checkbox" name="ck_has_para" <?php echo $ques->has_paragraph?'checked':''; ?> id="ck_has_para" value="1" /><br/><br/>


        <label for="txt_tag">Tags:</label>
        <p><input type="text" name="txt_tag" id="txt_tag" data-provide="tag" class="input-tag" value="<?php echo $ques->tags; ?>" placeholder="Write question tag"></p>
        
        <label for="ddl_exam_name">Previous Exam:</label> 
        <p>
        <input type="hidden" name="hdn_cat" value="">
        <select name="ddl_exam_name[]" class='multiselect' multiple="multiple" id="ddl_exam_name">
            <?php 
            if($prev_exam)
            {
                foreach ($prev_exam as $pe)
                {
                    $selected='';
                    if($sel_prev_exam)
                    {
                        foreach ($sel_prev_exam as $spe) 
                        {
                            $selected=$spe->exam_id==$pe->id?'selected':''; 
                        }
                    }
                    echo "<option {$selected} value='{$pe->id}'>{$pe->name}</option>";
                }  
            }   
            ?>
        </select>
      
            </p>

        </div>
        <!-- right column end -->

        <div class="clearfix"></div>
        <br/>
        <div class="btn-row">
            <button type="submit" name="btn_save" class="btn btn-info" value="1"><i class="icon-ok-circle"></i>&nbsp;Update</button>&nbsp;&nbsp;
            <a href="<?php echo base_url(); ?>admin/question_bank" class="btn btn-danger" title="Cancel"><i class="icon-remove-circle"></i>&nbsp;Cancel</a>
        </div>
    </form>
    <!-- form end -->

</fieldset>

<!-- javascript start -->
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/bootstrap-multiselect.js'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap-multiselect.css">
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>
<script type="text/javascript">
    $(document).ready(function(){

        var ddl_name=$('#ddl_exam_name'),
        ddl_subject=$('#ddl_subject'),
        ddl_chapter_group=$('#ddl_chapter_group'),
        ddl_chapter=$('#ddl_chapter'), 
        action_change_chapter_group='<?php echo base_url(); ?>admin/add_question/get_chapter_group',
        action_change_chapter='<?php echo base_url(); ?>admin/add_question/get_chapter';
      
        bindDropdownOnChange(ddl_subject,ddl_chapter_group,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group,ddl_chapter,action_change_chapter);
    

        $('#txt_ques').blur(function(){
            var txt_to_match=$(this).val(),
                cat=exam_cat.children(':selected').val();
            if(cat!=-1)
            { 
            $.ajax({
                url:'<?php echo base_url(); ?>admin/add_question/find_similar_question',
                type:'GET',
                data:{ques:txt_to_match,cat:cat},
                success:function(msg){
                    $('#msg').html(msg);
                }
            });
            }
        });

        //$('.multiselect').multiselect({enableFiltering:true,buttonWidth:'auto'});

    });
</script>

<!-- javascript end -->