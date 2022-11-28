<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>asset/css/chosen.css"/>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>-->
<style>
    .ck_list
    {
        overflow-y:scroll;
    }
</style>
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<fieldset class="form-horizontal input-form">
	<legend>Add Comprehension</legend>
	<form  action="<?php echo base_url(); ?>admin/manage_comprehension/save" method="post">
        <div style="margin-left:0;" class="span12">
        <label for="txt_title">Title:</label>
        <input type="text" name="txt_title" id="txt_title">
    	<label for="txt_comprehension">Details:</label>
    	   <?php echo $this->ckeditor->editor("txt_comprehension",""); ?>
            <br/>
        <button type="submit" class="btn btn-default" name="btnSave"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
        &nbsp;&nbsp;<button type='reset' class='btn btn-info'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
    <!--    <input type="submit" class="fa fa-save" name="btnSave" value="Save"/> -->
        </div>
	</form>
</fieldset>

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/common.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.quicksearch.js" ></script>
<script type="text/javascript">
    $(document).ready(function(){

        var examcat=$('#ddl_exam_cat'),
            chapter_group=$('#ddl_chapter_group'),
            chapter=$('#ddl_chapter'),
            ddl_subject=$('#ddl_subject'),
            ddl_question=$('#ddl_question'),
            action_chapter_group='<?php echo base_url(); ?>admin/add_question/get_chapter_group',
            action_chapter='<?php echo base_url(); ?>admin/add_question/get_chapter',
            action_change_exam_name='<?php echo base_url(); ?>admin/manage_comprehension/get_exam_ques';

        examcat.change(function(){
            var eid=$(this).val();
             $.ajax({
            url: '<?php echo base_url(); ?>admin/manage_comprehension/get_subjects',
            type: 'POST',
            data: {eid:eid },
            })
            .done(function(data) {
                ddl_subject.html(data);
            });
        });
       


        //binding exam name by exam category    
        bindDropdownOnChange(ddl_subject,chapter_group,action_chapter_group);

        //binding subject by exam name
        bindDropdownOnChange(chapter_group,chapter,action_chapter);

        chapter.on("change",function(){

            var changeVal=chapter.children(":selected").val();

            if(changeVal>0){
                $.ajax({
                    url:action_change_exam_name,
                    type:'POST',
                    data:{eid:changeVal},
                    success:function(msg){

                        $('#qlist').html(msg);
                        $('#qsearch').quicksearch('.ck_list ul li');
                    }

                });
                
                
            }
        });


    });
</script>