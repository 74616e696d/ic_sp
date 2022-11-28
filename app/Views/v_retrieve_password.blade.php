@extends('front_layout.layout')

@section('style')
<style>
    .change-pass{
        margin-top: 10px;
        padding: 15px 0;
        text-align: center;
    }
    .form-horizontal{
        margin-top: 5%;
    }
  .h1, .h2, .h3, .h4, .h5, .h6, body, h1, h2, h3, h4, h5, h6{
    font-family:"Roboto",sans-serif;
  }
</style>
@stop

@section('content')
<div class="container class='change-pass">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form method='post' class='form-horizontal' action="<?php echo base_url(); ?>retrieve_password/send">
            <div class="form-group">
                <div class="col-sm-12 col-lg-3 col-lg-offset-5 col-md-offset-5">
                    <h3>Set New Password</h3>
                </div>
            </div>
        @if($ci->session->flashdata('msg'))
            $ci->session->flashdata('msg')
        @endif

        <input type="hidden" name="hdn_key" value="<?php echo $key; ?>">
        <div class="form-group">
            <label for="pass" class="col-sm-12 col-lg-5 text-right">New Password</label>
            <div class="col-sm-12 col-lg-3">
                <input type='password' class='form-control' name='pass' id='pass' required='required' placeholder='New Password'/>
            </div>
        </div>

        <div class="form-group">
            <label for="pass" class="col-sm-12 col-lg-5 text-right">Type Password Again</label>
            <div class="col-sm-12 col-lg-3">
                <input type="password" class='form-control' name="pass_again" id="pass_again" placeholder='Type Password Again'>
            </div>
        </div>
        <div class=" col-sm-12 col-lg-offset-5 col-md-offset-5">
        <button type="submit" class="btn btn-primary">Change</button>
        </div>
        </form>
    </div>
</div>

@stop


<div id='footer'>

</div>