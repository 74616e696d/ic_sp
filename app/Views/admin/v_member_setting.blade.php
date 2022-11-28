@extends('admin_master.layout')

@section('content')
    <div>
        {{render_message()}}
    </div>

    <form action="<?php echo base_url(); ?>admin/member_setting/save" method="post">
        <!-- <label for="ddl_mem_type">Membership Types:</label> -->
        <select name="ddl_mem_type" id="ddl_mem_type">
            <option value="-1">Select Membership Types</option>
            <?php
            if($mem_types){
              foreach($mem_types as $mt){
                  echo "<option value='{$mt->id}'>{$mt->name}</option>";
              }
            }
            ?>
        </select>

        <div id="setting_meta">

        </div>
    </form>
@stop


@section('style')
<style>
    select
    {
        margin-left:28px;
    }
    button
    {
        margin-left:28px;
    }
</style>
@stop

@section('script')
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/common.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
           // $('#btn_save').css('display','none');
            $('#ddl_mem_type').change(function(){
                var mem_val=$(this).children(':selected').val();
                if(mem_val!=-1)
                {
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/member_setting/mem_meta',
                    type:'GET',
                   data:{mem_type:mem_val},
                   success:function(msg){
                        $('#setting_meta').html(msg);
                    }
                });

                }else{
                    $('#setting_meta').html('');

                }
            });
        });
    </script>
@stop




