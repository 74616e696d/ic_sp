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

<div class="clearfix"></div>
<!-- message box start -->
<div id="msg">
    <?php 
   render_message(); 
   $this->my_validation->display_message();
    ?>
</div>
<!-- message box end -->
<fieldset class="form-horizontal input-form">
    <legend><div>Link Chapters</div></legend>
    <!-- form start -->
    <?php echo form_open_multipart(base_url()."admin/chapter_settings/add");?>
        <span id="err_exam"></span>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label for="ddl_exam_cat1" class="control-label">Exam Category:</label>
                    <select name="ddl_exam_cat1" id="ddl_exam_cat1">
                        <option value="-1">Select Exam Category</option>
                        <?php if($cats){foreach ($cats as $c) {
                        	$selected=$c->id==old_value('exam_cat')?'selected':'';
                        	echo "<option {$selected} value='{$c->id}'>{$c->name}</option>";
                        }} ?>
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ddl_subject1">Subject:</label>
                    <input type="hidden" name="hdn_subject" value="3">
                    <div class="controls">
                        <select name="ddl_subject1" id="ddl_subject1">
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
                    <label class="control-label" for="ddl_chapter_group1">Chapter Group:</label>
                    <input type="hidden" name="hdn_chapter_group" value="6">
                    <div id="chptr_group" class="controls">
                        <select name="ddl_chapter_group1" id="ddl_chapter_group1">
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
                    <label for="ddl_chapter1" class="control-label">Chapter:</label>
                    <input type="hidden" name="hdn_chapter" value="4">
                    <div id='chaptr' class="controls">
                      <!--   <ul class="inline"> -->
                      <select name="ddl_chapter1" id="ddl_chapter1" onchange="getReferenceChapter(this.value);">
                          <option value="-1">Select Chapter</option>
                              <?php
                            if($chapters){
                                foreach ($chapters as $cpt) {
                                    $selected=old_value('chapter')==$cpt->id?'selected':'';
                                    echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                }
                            }
                            ?>
                      </select>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label for="ddl_exam_cat2" class="control-label">Exam Category:</label>
                    <select name="ddl_exam_cat2" id="ddl_exam_cat2">
                        <option value="-1">Select Exam Category</option>
                        <?php if($cats){foreach ($cats as $c) {
                            echo "<option {$selected} value='{$c->id}'>{$c->name}</option>";
                        }} ?>
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ddl_subject2">Subject:</label>
                    <input type="hidden" name="hdn_subject" value="3">
                    <div class="controls">
                        <select name="ddl_subject2" id="ddl_subject2">
                            <option value="-1">Select Subject</option>
                            <?php
                            if($subjects){
                                foreach ($subjects as $sbj) 
                                {
                                    echo "<option {$selected} value='{$sbj->id}'>{$sbj->name}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="ddl_chapter_group">Chapter Group:</label>
                    <input type="hidden" name="ddl_chapter_group2" value="6">
                    <div id="chptr_group" class="controls">
                        <select name="ddl_chapter_group2" id="ddl_chapter_group2">
                            <option value="-1">Select Chapter Group</option>
                             <?php
                                if($chapter_group){
                                    foreach ($chapter_group as $cpt) {
                                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="ddl_chapter2" class="control-label">Chapter:</label>
                    <input type="hidden" name="hdn_chapter" value="4">
                    <div id='chaptr' class="controls">
                      <!--   <ul class="inline"> -->
                      <select name="ddl_chapter2" id="ddl_chapter2" onchange="getReferenceChapter(this.value);">
                          <option value="-1">Select Chapter</option>
                              <?php
                            if($chapters){
                                foreach ($chapters as $cpt) {
                                    echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                }
                            }
                            ?>
                      </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br/>
        <div class="btn-row">
            <a href="<?php echo base_url(); ?>admin/chapter_settings" class="btn btn-danger pull-right" title="Cancel"><i class="icon-remove-circle icon-white"></i>&nbsp;Cancel</a>&nbsp;&nbsp;
            <button type="submit" name="btn_save_new" class="btn btn-info pull-right" value="2"><i class="icon-ok-circle icon-white"></i>&nbsp;Save &amp; New</button>&nbsp;&nbsp;
            <button type="submit" name="btn_save" class="btn btn-info pull-right" value="1"><i class="icon-ok-circle icon-white"></i>&nbsp;Save</button>
        </div>
    </form>
    <!-- form end -->
</fieldset>
<!-- <div id="loader"></div> -->
<fieldset class="form-horizontal input-form">
    <legend><div>Copy Chapter Questions</div></legend>
    <!-- form start -->
    <?php echo form_open_multipart(base_url()."admin/chapter_settings/copy_question");?>
        <span id="err_exam"></span>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label for="ddl_exam_cat3" class="control-label">Exam Category:</label>
                    <select name="ddl_exam_cat3" id="ddl_exam_cat3">
                        <option value="-1">Select Exam Category</option>
                        <?php if($cats){foreach ($cats as $c) {
                            $selected=$c->id==old_value('exam_cat1')?'selected':'';
                            echo "<option {$selected} value='{$c->id}'>{$c->name}</option>";
                        }} ?>
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ddl_subject3">Subject:</label>
                    <input type="hidden" name="hdn_subject" value="3">
                    <div class="controls">
                        <select name="ddl_subject3" id="ddl_subject3">
                            <option value="-1">Select Subject</option>
                            <?php
                            if($subjects){
                                foreach ($subjects as $sbj) 
                                {
                                    $selected=old_value('subject1')==$sbj->id?'selected':'';
                                    echo "<option {$selected} value='{$sbj->id}'>{$sbj->name}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="ddl_chapter_group3">Chapter Group:</label>
                    <input type="hidden" name="hdn_chapter_group" value="6">
                    <div id="chptr_group" class="controls">
                        <select name="ddl_chapter_group3" id="ddl_chapter_group3">
                            <option value="-1">Select Chapter Group</option>
                             <?php
                                if($chapter_group){
                                    foreach ($chapter_group as $cpt) {
                                        $selected=old_value('chapter_group1')==$cpt->id?'selected':'';
                                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="ddl_chapter3" class="control-label">Chapter:</label>
                    <input type="hidden" name="hdn_chapter" value="4">
                    <div id='chaptr' class="controls">
                      <!--   <ul class="inline"> -->
                      <select name="ddl_chapter3" id="ddl_chapter3" onchange="getReferenceChapter(this.value);">
                          <option value="-1">Select Chapter</option>
                              <?php
                            if($chapters){
                                foreach ($chapters as $cpt) {
                                    $selected=old_value('chapter1')==$cpt->id?'selected':'';
                                    echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                }
                            }
                            ?>
                      </select>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label for="ddl_exam_cat4" class="control-label">Exam Category:</label>
                    <select name="ddl_exam_cat4" id="ddl_exam_cat4">
                        <option value="-1">Select Exam Category</option>
                        <?php if($cats){foreach ($cats as $c) {
                            echo "<option {$selected} value='{$c->id}'>{$c->name}</option>";
                        }} ?>
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ddl_subject4">Subject:</label>
                    <input type="hidden" name="hdn_subject" value="3">
                    <div class="controls">
                        <select name="ddl_subject4" id="ddl_subject4">
                            <option value="-1">Select Subject</option>
                            <?php
                            if($subjects){
                                foreach ($subjects as $sbj) 
                                {
                                    echo "<option {$selected} value='{$sbj->id}'>{$sbj->name}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="ddl_chapter_group">Chapter Group:</label>
                    <input type="hidden" name="ddl_chapter_group4" value="6">
                    <div id="chptr_group" class="controls">
                        <select name="ddl_chapter_group4" id="ddl_chapter_group4">
                            <option value="-1">Select Chapter Group</option>
                             <?php
                                if($chapter_group){
                                    foreach ($chapter_group as $cpt) {
                                        echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="ddl_chapter4" class="control-label">Chapter:</label>
                    <input type="hidden" name="hdn_chapter" value="4">
                    <div id='chaptr' class="controls">
                      <!--   <ul class="inline"> -->
                      <select name="ddl_chapter4" id="ddl_chapter4" onchange="getReferenceChapter(this.value);">
                          <option value="-1">Select Chapter</option>
                              <?php
                            if($chapters){
                                foreach ($chapters as $cpt) {
                                    echo "<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
                                }
                            }
                            ?>
                      </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br/>
        <div class="btn-row">
            <a href="<?php echo base_url(); ?>admin/chapter_settings" class="btn btn-danger pull-right" title="Cancel"><i class="icon-remove-circle icon-white"></i>&nbsp;Cancel</a>&nbsp;&nbsp;
            <button type="submit" name="btn_save_new" class="btn btn-info pull-right" value="2"><i class="icon-ok-circle icon-white"></i>&nbsp;Save &amp; New</button>&nbsp;&nbsp;
            <button type="submit" name="btn_save" class="btn btn-info pull-right" value="1"><i class="icon-ok-circle icon-white"></i>&nbsp;Save</button>
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

    var ddl_exam_cat1=$('#ddl_exam_cat1'),
        ddl_subject1=$('#ddl_subject1'),
        ddl_chapter_group1=$('#ddl_chapter_group1'),
        ddl_chapter1=$('#ddl_chapter1'),

        ddl_exam_cat2=$('#ddl_exam_cat2'),
        ddl_subject2=$('#ddl_subject2'),
        ddl_chapter_group2=$('#ddl_chapter_group2'),
        ddl_chapter2=$('#ddl_chapter2'),

        ddl_exam_cat3=$('#ddl_exam_cat3'),
        ddl_subject3=$('#ddl_subject3'),
        ddl_chapter_group3=$('#ddl_chapter_group3'),
        ddl_chapter3=$('#ddl_chapter3'),

        ddl_exam_cat4=$('#ddl_exam_cat4'),
        ddl_subject4=$('#ddl_subject4'),
        ddl_chapter_group4=$('#ddl_chapter_group4'),
        ddl_chapter4=$('#ddl_chapter4'),

        action_change_subject='<?php echo base_url(); ?>admin/chapter_settings/get_subjects',
        action_change_chapter_group='<?php echo base_url(); ?>admin/chapter_settings/get_chapter_group',
        action_change_chapter='<?php echo base_url(); ?>admin/chapter_settings/get_chapter';

      	bindDropdownOnChange(ddl_exam_cat1,ddl_subject1,action_change_subject);
        bindDropdownOnChange(ddl_subject1,ddl_chapter_group1,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group1,ddl_chapter1,action_change_chapter);

        bindDropdownOnChange(ddl_exam_cat2,ddl_subject2,action_change_subject);
        bindDropdownOnChange(ddl_subject2,ddl_chapter_group2,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group2,ddl_chapter2,action_change_chapter);


        bindDropdownOnChange(ddl_exam_cat3,ddl_subject3,action_change_subject);
        bindDropdownOnChange(ddl_subject3,ddl_chapter_group3,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group3,ddl_chapter3,action_change_chapter);

        bindDropdownOnChange(ddl_exam_cat4,ddl_subject4,action_change_subject);
        bindDropdownOnChange(ddl_subject4,ddl_chapter_group4,action_change_chapter_group);
        bindDropdownOnChange(ddl_chapter_group4,ddl_chapter4,action_change_chapter);
});
       
</script>

<style>
    div#chapter-list h2 {
        font-size: 18px;
        margin: 0;
        padding: 0;
        color: #615b5b;
        font-weight: normal;
        line-height: 23px;
    }
    div#chapter-list ul li {
        list-style: none;
        margin: 3px 0;
        padding: 0;
    }
</style>

<style>
/* The container */
.lab-container {
    display: block;
    position: relative;
    padding-left: 22px;
    margin-bottom: 4px;
    cursor: pointer;
    font-size: 14px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.lab-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 4px;
    left: 0;
    height: 15px;
    width: 15px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.lab-container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.lab-container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.lab-container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.lab-container .checkmark:after {
    left: 5px;
    top: 1px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>