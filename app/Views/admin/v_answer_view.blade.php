<script type="text/javascript" src="<?php echo base_url(); ?>asset/admin/js/custom.js"></script>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Exam Category</th>
        <th>Exam Name</th>
        <th>Subject</th>
        <th>Chapter</th>
        <th>Period</th>
        <th>Question</th>
        <th>Answer</th>
        <th>Edit</th>
        <th>Delete</th>
        <th></th>
    </tr>
    </thead>
    <?php 
	echo $ques;
	?>
</table>


    <div id="add_ans_dlg" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Answer Options</h3>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
<script type="text/javascript">
   // $(document).ready(function(){
        $('#add_ans_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });
    //});

</script>