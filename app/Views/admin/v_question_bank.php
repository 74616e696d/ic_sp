<script type="text/javascript" src="<?php echo base_url(); ?>asset/admin/js/custom.js"></script>
<style>
    select{width:145px;}
    .tbl-responsive
    {
        width: 100%;
        overflow-x:scroll;
        overflow-y:hidden;
    }
</style>
<!-- message box start -->
<div><?php render_message(); ?></div>
<!-- message box end -->
<!--  <div id='loader'>
    <img src="<?php echo base_url(); ?>asset/img/loader.gif" alt="loading...">
</div> -->
<table class='table' style="width:95%;background:#f5f5f5;">    
    <tr>
     <td>
     <input style='width:50px;' type="text" name="txt_qid" id="txt_qid" value="<?php echo $selected_qid; ?>" placeholder='id'>
     </td>
    
     <td>
        <select name="ddl_test_name" id="ddl_test_name">
            <option value="-1">Select Test Name</option>
            <?php
            if($test_name)
            {
                foreach ($test_name as $test) {
                    $test_name=$test->test_type==15?$test->test_name:ref_text_model::get_text($test->ref_id);
                    //$test_name=empty($test->ref_id)?ref_text_model::get_text($test->ref_id);
                    $sel_test=$test->id==$selected_test?'selected':'';
                    echo "<option {$sel_test} value='{$test->id}'>{$test_name}</option>";
                }
            }
            ?>
        </select>
    </td>
    <td>
        
        <select style="width:180px;" name="ddl_exam_subject" id="ddl_exam_subject">
        <option value="-1">Select Exam Subject</option>
         <?php if($subjects){foreach ($subjects as $sbj) {
            $sel_subj=$sbj->id==$selected_subject?'selected':'';
            echo "<option {$sel_subj} value='{$sbj->id}'>{$sbj->name}</option>";
        }} ?>
        </select>
    </td>
   
    <td>
        <select style="width:180px;" name="ddl_chapter_group" id="ddl_chapter_group">
            <option value="-1">Select Chapter Group</option>
            <?php if($chapter_group){foreach ($chapter_group as $cg) {
                $sel_chapter_group=$cg->id==$selected_chapter_group?'selected':'';
                echo "<option value='{$cg->id}'>{$cg->name}</option>";
            }}?>
        </select>
    </td>
    <td>
          <select style="width:180px;" name="ddl_chapter" id="ddl_chapter">
            <option value="-1">Select Chapter</option>
            <?php if($chapter){foreach ($chapter as $c) {
                $sel_chapter=$c->id==$selected_chapter?'selected':'';
                echo "<option value='{$c->id}'>{$c->name}</option>";
            }}?>
        </select>
    </td>
    <td>
        <a id="search" class="btn btn-info btn-block" href="#"><i class="icon-search icon-white"></i>GO</a>
    </td>
    </tr>
</table>
<div class="top-pagi">
<?php echo $display_page; ?>
</div>
<br/>
<div class="tbl-responsive">
<table class="table table-striped">
    <thead>
    <tr>
        <!-- <th>Exam Name</th> -->
        <th>Subject</th>
        <th>Question</th>
        <th>Options</th>
        <th>Hints</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <?php echo $ques; ?>

</table>
</div>
<div class="bottom-pagi">
<?php echo $display_page; ?>
</div>
<p>Note:Green colored answers are correct answer</p>

    <div id="add_ans_dlg" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Answer Options</h3>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
        <button class="btn btn-info pull-left" aria-hidden="true" >Save</button>
            <button class="btn pull-right" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/common.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
    
        $('#add_ans_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });


           var exam_cat=$('#ddl_exam_name'),
            subject_name=$('#ddl_exam_subject'),
            chapter_group=$('#ddl_chapter_group'),
            chapter=$('#ddl_chapter'),
            test_name=$('#ddl_test_name'),
            action_chapter_group='<?php echo base_url(); ?>admin/add_question/get_chapter';
            action_chapter='<?php echo base_url(); ?>admin/add_question/get_chapter_group';
        bindDropdownOnChange(subject_name,chapter_group,action_chapter_group);
        bindDropdownOnChange(chapter_group,chapter,action_chapter);

        //making query string for search
        var skey1=subject_name.val(),
            skey2=chapter_group.val(),
            skey3=chapter.val(),
            skey4=test_name.val(),
            qid=$('#txt_qid').val(),
            skey5=isInteger(qid)?qid:-1,
            make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
           $('#search').attr('href',make_url);
            //alert(skey5);

             subject_name.change(function(){
                skey1=subject_name.children(':selected').val();
                if(skey1!=-1)
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+-1+'/'+-skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                $('#search').attr('href',make_url);
            });

            chapter_group.change(function(){
                skey2=chapter_group.children(':selected').val();
                if(skey2!=-1)
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+-skey2+'/'+-1+'/'+skey4+'/'+skey5;
                }
                $('#search').attr('href',make_url);
            });

            chapter.change(function(){
                skey3=chapter.children(':selected').val();
                if(skey3!=-1)
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+-skey2+'/'+-1+'/'+skey4+'/'+skey5;
                }
                $('#search').attr('href',make_url);
            });

            test_name.change(function(){
                skey4=test_name.children(':selected').val();
                if(skey4!=-1)
                {
                     make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                else
                {
                     make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+-1+'/'+skey5;
                }

                $('#search').attr('href',make_url);
            });
            $('#txt_qid').blur(function() {
                skey5=$(this).val();
                if(skey5!='')
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+skey5;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/question_bank/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4+'/'+-1;
                }
                $('#search').attr('href',make_url);
            });
            //end making query string for search
            

            // $('#loader').hide().ajaxStart(function(){
            // $(this).show();
            // }).ajaxStop(function() {$(this).hide(); });

    });

    function isInteger(n) {
        return /^[0-9]+$/.test(n);
    }
</script>