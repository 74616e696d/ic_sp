
<fieldset class="form-horizontal input-form">
    <legend><div>Edit Question</div></legend>
    <div>
        <?php echo success_message($this->session->flashdata('success')); ?>
        <?php echo info_message($this->session->flashdata('info')); ?>
        <?php echo warning_message($this->session->flashdata('warning')); ?>
        <?php echo error_message($this->session->flashdata('error')); ?>
    </div>
<?php echo form_open_multipart(base_url()."admin/question_bank/updateQuestion");?>
<input type="text" name="pid" value="<?php echo $query->id;?>">
<label>Question</label>
<textarea name='txtq'><?php echo $query->question;?></textarea>
<label>Answer Options(seperate by'|'):</label><textarea name="ans"><?php echo $query->options;?></textarea>
<label>Years:</label><input type='text' name='year' value='<?php echo $query->period;?>'></textarea><br/>
<input type='submit' name='btnupdate' value='Update Now!' class='btn'>
</form>
</fieldset>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ddl_exam').change(function(){
            var exam_id=$('#ddl_exam option:selected').val();
            if(exam_id>0){
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/set_question/get_subject',
                    type:'POST',
                    data:{eid:exam_id},
                    success:function(msg){
                        $('#ddl_subject').html(msg);
                    }

                });
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/add_question/exam_by_cat',
                    type:'POST',
                    data:{eid:exam_id},
                    success:function(msg){
                        $('#ddl_exam_name').html(msg);
                    }

                });
            }else
            {
                //$('#err_exam').html('<span style="color:#900;">select exam!</span>').fadeOut('20000');
            }

        });


        $('#ddl_subject').change(function(){
            var sub_id=$('#ddl_subject option:selected').val();
            $.ajax({
                url:'<?php echo base_url(); ?>admin/set_question/get_chapter',
                type:'POST',
                data:{prnt:sub_id},
                success:function(msg){
                    $('#ddl_chapter').html(msg);
                }
            });
        });
    });
</script>