@extends('admin_master.layout')


@section('content')
<table class='table' style="width:95%;background:#f5f5f5;">    
    <tr>
     <td>
     <input style='width:50px;' type="text" name="txt_qid" id="txt_qid" value="" placeholder='id'>
     </td>
    
     <td>
        <select name="ddl_test_name" id="ddl_test_name">
            <option value="">Select Test Name</option>
            <?php
            if($test_name)
            {
                foreach ($test_name as $test) {
                    $test_name=$test->test_type==15?$test->test_name:ref_text_model::get_text($test->ref_id);
                    echo "<option value='{$test->id}'>{$test_name}</option>";
                }
            }
            ?>
        </select>
    </td>
    <td>
        
        <select style="width:180px;" name="ddl_exam_subject" id="ddl_exam_subject">
        <option value="">Select Exam Subject</option>
         <?php if($subjects){foreach ($subjects as $sbj) {
            echo "<option {$sel_subj} value='{$sbj->id}'>{$sbj->name}</option>";
        }} ?>
        </select>
    </td>
   
    <td>
        <select style="width:180px;" name="ddl_chapter_group" id="ddl_chapter_group">
            <option value="">Select Chapter Group</option>
            <?php if($chapter_group){foreach ($chapter_group as $cg) {
                echo "<option value='{$cg->id}'>{$cg->name}</option>";
            }}?>
        </select>
    </td>
    <td>
          <select style="width:180px;" name="ddl_chapter" id="ddl_chapter">
            <option value="">Select Chapter</option>
            <?php if($chapter){foreach ($chapter as $c) {
                echo "<option value='{$c->id}'>{$c->name}</option>";
            }}?>
        </select>
    </td>

   <!--  <td>
       
   </td> -->
    </tr>
    <tr>
        <td colspan="2">
            <input type="text" name="txtQues" id="txtQques" placeholder="Question">
        </td>
        <td>
            <label class="checkbox">
                <input type="checkbox" name="is_changeable" id="is_changeable" value="1"> Is Changeable
            </label>
        </td>
        <td><a id="search" class="btn btn-info btn-block" href="#"><i class="icon-search icon-white"></i> GO</a></td>
        <td></td>
        <td></td>
    </tr>
</table>
<br/>
<div class="tbl-responsive">
<table id='qlist' class="table table-striped">
    <thead>
    <tr>
        <!-- <th>Exam Name</th> -->
        <th>Id</th>
        <th>Subject</th>
        <th style='width:30%'>Questions</th>
        <th style='width:20%'>Options</th>
        <th>Hints</th>
        <th>Last Modified</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
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
@stop


@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/datatable/css/dataTables.bootstrap.min.css">
<style>
img
{
with:180px;
}
.dataTables_filter{display: none;}
.dataTables_length{display: none;}
table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}

table.dataTable thead .sorting::after, table.dataTable thead .sorting_asc::after, 
table.dataTable thead .sorting_desc::after, 
table.dataTable thead .sorting_asc_disabled::after,
table.dataTable thead .sorting_desc_disabled::after {
  bottom: 8px;
  display: none;
  font-family: "Glyphicons Halflings";
  opacity: 0.5;
  position: absolute;
}
</style>
<style>
    select{width:145px;}
    .tbl-responsive
    {
        width: 100%;
        overflow-x:scroll;
        overflow-y:hidden;
    }
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/vendor/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/admin/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $('#add_ans_dlg').on('hidden', function () {
        $(this).removeData('modal');
    });

    subject_name=$('#ddl_exam_subject'),
    chapter_group=$('#ddl_chapter_group'),
    chapter=$('#ddl_chapter'),
    test_name=$('#ddl_test_name'),
    action_chapter_group='<?php echo base_url(); ?>admin/add_question/get_chapter';
    action_chapter='<?php echo base_url(); ?>admin/add_question/get_chapter_group';
    bindDropdownOnChange(subject_name,chapter_group,action_chapter_group);
    bindDropdownOnChange(chapter_group,chapter,action_chapter);

        //display job list in datatables
        table = $('#qlist').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            pageLength:100,
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "{{ $base_url }}admin/question_bank/question_list_dt",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],
        });//end display job list in datatables

        $('#qlist').on( 'draw.dt', function () {
                var info = table.page.info();
                console.dir(info);
                var displayed=info.recordsDisplay;
                var total_item=info.recordsTotal;
                $('#qlist_info').html('Total :'+displayed+' Records from '+total_item);
        });

        //search datatable
        $('#search').click(function(e) {
            e.preventDefault();
            var id=$('#txt_qid').val();
            var test=$('#ddl_test_name').val();
            var subject=$('#ddl_exam_subject').val();
            var chapter_group=$('#ddl_chapter_group').val();
            var chapter=$('#ddl_chapter').val();
            var ques=$('#txtQques').val();
            var is_changeable=$('#is_changeable').is(':checked')?true:false;
            var term={id:id,test:test,subject:subject,chapter_group:chapter_group,chapter:chapter,ques:ques,is_changeable:is_changeable};
            table.search(JSON.stringify(term)).draw();
        });
        //end search datatable
});

function isInteger(n) {
    return /^[0-9]+$/.test(n);
}
</script>
@stop