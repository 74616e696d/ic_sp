@extends('admin_master.layout')


@section('content')

<!-- message box start -->
<div><?php render_message(); ?></div>
<!-- message box end -->

<!-- search start -->
<div class="form-inline">
     <input style='width:50px;' type="text" name="txt_qid" id="txt_qid" value="<?php echo $selected_id==-1?'':$selected_id; ?>" placeholder='id'>
    
    <select name="cat" id="cat">
        <option value="-1">Select Category</option>
        @if($cats)
            @foreach($cats as $ct)
            <?php $selected=$selected_cat==$ct->id?'selected':''; ?>
            <option {{ $selected }}  value="{{$ct->id}}">{{$ct->name}}</option>
            @endforeach
        @endif
    </select>

    <select name="ddl_test_name" id="ddl_test_name">
        <option value="-1">Select Model Test</option>
    
    </select>

    <a id="search" class="btn btn-info" href="#"><i class="icon-search icon-white"></i>GO</a>
</div>
<!-- search end -->

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
        <th style='width:30%'>Question</th>
        <th style='width:20%'>Options</th>
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



@stop

@section('style')
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
<script type="text/javascript" src="{{$base_url}}asset/admin/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/common.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
    
        $('#add_ans_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });

       var test_name=$('#ddl_test_name'),
            cat=$('#cat'),
            action_name_test='{{$base_url}}admin/manage_model_test_ques/get_model_test',
            sel_test='{{$selected_test}}';
            $.ajax({
                url:action_name_test,
                type:'POST',
                data:{eid:cat.val(),sel:sel_test}
            })
            .done(function(data){
                test_name.html(data);
            });

        bindDropdownOnChange(cat,test_name,action_name_test);

        //making query string for search
            var skey2=test_name.val(),
            qid=$('#txt_qid').val(),
            skey1=isInteger(qid)?qid:-1,
            skey3=cat.val(),
            make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+skey2+'/'+skey3;
           $('#search').attr('href',make_url);

            $('#cat').change(function(){
                skey3=$(this).val();

                if(skey3!=-1)
                {
                 make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+skey2+'/'+skey3;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+skey2+'/'+-1;
                }
                $('#search').attr('href',make_url);
            });

            $('#ddl_test_name').change(function(){
                skey2=$(this).val();

                if(skey2!=-1)
                {
                 make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+skey2+'/'+skey3;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+-1+'/'+skey3;
                }
                $('#search').attr('href',make_url);
            });
    

   
            $('#txt_qid').blur(function() {
                skey1=isInteger($(this).val())?$(this).val():-1;
                if(skey1!='')
                {
                    make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+skey1+'/'+skey2+'/'+skey3;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_model_test_ques/index/'+-1+'/'+skey2+'/'+skey3;
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
@stop