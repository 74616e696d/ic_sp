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
       render_message(); 
       $this->my_validation->display_message();
        ?>
    </div>
    <!-- message box end -->

    <!-- form start -->
    <?php echo form_open_multipart(base_url()."admin/add_question_manually/add");?>
      <input type="hidden" name="hdn_test_id" value="<?php echo $test_id; ?>">

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

        <br/>
        <!-- left column start -->
        <div style="margin-left:0" class="span8">
        <label for="txt_ques">Question:</label>
 
        <?php echo $this->ckeditor->editor("txt_ques","");?>

        <label>Question Options:</label>
        <?php echo $this->ckeditor->editor("txtoptions","");?>

          <label for="txt_hints">Hints</label>
        <?php echo $this->ckeditor->editor("txt_hints",old_value('hints'));?>

        <br>
        <label for="ck_has_para">Has Paragraph:</label>
        <input type="checkbox" name="ck_has_para" id="ck_has_para" <?php if(old_value('has_paragraph'))echo 'checked'; ?> value="1" />

      </div>  <!-- left column end -->

        <!-- right column start -->
        <div class="span2">
        
      <br/><br/>

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
<!-- javascript start -->
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/bootstrap-multiselect.js'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap-multiselect.css">
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>

<script type="text/javascript">
$(document).ready(function(){

    var ddl_exam_cat=$('#ddl_exam_cat'),
        ddl_name=$('#ddl_exam_name'),
        ddl_subject=$('#ddl_subject'),
        ddl_chapter_group=$('#ddl_chapter_group'),
        ddl_chapter=$('#ddl_chapter'),
        action_change_subject='<?php echo base_url(); ?>admin/add_question/get_subjects',
         action_change_prev_exam='<?php echo base_url(); ?>admin/add_question/get_prev_exam',
        action_change_chapter_group='<?php echo base_url(); ?>admin/add_question/get_chapter_group',
        action_change_chapter='<?php echo base_url(); ?>admin/add_question/get_chapter';

        bindDropdownOnChange(ddl_exam_cat,ddl_subject,action_change_subject);
        bindDropdownOnChange(ddl_subject,ddl_chapter_group,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group,ddl_chapter,action_change_chapter);

       ddl_exam_cat.change(function(){
        $eid=$(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/add_question/get_prev_exam',
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
                    url:'<?php echo base_url(); ?>admin/add_question/find_similar_question',
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

<!-- javascript end -->