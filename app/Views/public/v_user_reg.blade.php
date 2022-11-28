@extends('front_master.master')
@section('content')

<section class="content content-dark bg-signup">
    <div>
    </div>
    <div class="container">
   

        @if($success==1)
        {{render_message()}}
        @else
        <div id="msg">
            
        </div>

        <hr class="invisible">
        <div class="row">
            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-4 col-lg-offset-4">
                  <h1>সাইন আপ করে সদস্য হোন</h1>
                </div>

               
                @if($session->getFlashdata('error'))
                <?php $type=$session->getFlashdata('action_type'); ?>
                @if($type!='login')
                {{render_message()}}
                @endif
                @endif
                
                
                
                     
                <form class="form-horizontal" id='frm-reg' role="form" action="<?php echo base_url(); ?>/public/user_reg/add" method='post'>

                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">ইমেইল:</label>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="email" name="txt_email" id="txt_email" placeholder='ইমেইল' class='form-control' <?php echo old_value('email', $session); ?> required="required"/>
                            <span class="form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">মোবাইল:</label>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" name="txt_mobile" id="txt_email" placeholder='মোবাইল' class='form-control' <?php echo old_value('phone', $session); ?> required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">পাসওয়ার্ড:</label>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="password" name="txt_pass" id="txt_pass" placeholder='পাসওয়ার্ড' class='form-control' required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">পাসওয়ার্ড নিশ্চিত করুন:</label>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="password" name="txt_pass_retype" placeholder='পাসওয়ার্ড নিশ্চিত করুন' class='form-control' id="txt_pass_retype" required="required"/>
                            <span class='pass_conf_msg'></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-4 col-lg-offset-4">
                           <!--  <button type="submit" class="btn btn-success has-spinner" id='btn_sign_up'>
                                 সাইন আপ
                            </button> -->
                            
                            <input type="submit" class="btn btn-primary" id='btn_sign_up' value="সাইন আপ">
                        </div>
                    </div>
                </form>
            </div>
      
            
           
                
        </div>
        @endif
    </div>
</section>

@stop
 

@section('style')
<style>
    .form-horizontal .control-label
    {
    padding-top:0;
    text-align:right;
    }

    @media screen and (max-width: 680px) {
        .personal-info h1{
            font-size: 25px;
        }
       .form-horizontal .control-label{
        text-align: left;
       }
    }
    .form-control-feedback,.pass_conf_msg{
        color: red;
    }
</style>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#txt_email').blur(function(){
        var email=$(this).val();
        $.ajax({
            url:'{{ $base_url }}public/user_reg/check_email',
            type: 'POST',
            dataType:'json',
            data: {email:email}
        })
        .done(function(res) {
            if(res.ok)
            {
                $('.form-control-feedback').html('Email already exists !!');
                $('#btn_sign_up').attr('disabled','disabled');
            }
            else
            {
                $('.form-control-feedback').html('');
                $('#btn_sign_up').removeAttr('disabled','disabled');
            }
        });
        
    });

    $('#txt_pass_retype').blur(function(){
        var pass=$('#txt_pass').val();
        var pass_retype=$(this).val();
        if(pass!=pass_retype)
        {
            $('.pass_conf_msg').html('Password and retype password does not match !!');
            $('#btn_sign_up').attr('disabled','disabled');
        }
        else
        {
            $('.pass_conf_msg').html('');
            $('#btn_sign_up').removeAttr('disabled','disabled');
        }
    });
});
</script>
@stop