@extends('master.layout')
@section('content')
<div class="row" style="min-height: 600px;">
    <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 style='width:100%;' class="bx-title"><span>By Upgrading Your Membership You Can Enjoy</span>
                @if($pending)
                <a style='margin-right:8px;' class='pull-right btn btn-info btn-xs' href="{{ $base_url }}public/upgrade/remove_pending"><i class="fa fa-refresh"></i> Reset Pending Request</a>
                @endif
                </h4>
            </div>
            <div class="bx bx-body">
                <ul id='upgrade-msg' class='list-unstyled'>
                </ul>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 upg">
                       
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#">All Subjects </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#"> Your Statistics </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#">Mistake List </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#"> All Chapters </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#">Vocabulary App </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#">All Model Tests </a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#">All Previous Exams </a>
                        </div>
                         <div class="col-xs-6 col-md-3">
                            <img src="{{$base_url}}asset/member/img/icon.png"/>
                            <a href="#"> Access to all Categories</a>
                        </div>
                    </div>
                </div>
                <br>
                <form action="{{$base_url}}public/upgrade/send" method="post">
                    {{ $membership }}
                </form>
                
                <br>
                <!-- <img class='img-responsive' src="{{$base_url}}asset/frontend/img/payment.png" alt="">
                <br> -->
            </div>
        </div>
    </div>
</div>
@stop
@section('style')
<link href="{{$base_url}}asset/css/square/blue.css" rel="stylesheet" />
<style>
    #upgrade-msg
    {
    font-size:15px;
    line-height:18px;
    }
    #upgrade-msg li
    {
    color:#444;
    }
    #upgrade-msg li >span
    {
    /*color:#FF9C3A;*/
    }

    .upg>div
    {
    	padding:5px;
    }
    .upg a{
    font-size:14px;
    }
    .pk {
    background: #0177bf;
    padding: 5px;
    border-radius: 10px;
    margin-right:5px;
    /*min-height: 115px;*/
    /*width:16%;*/
    }
    .pk {
    color: #fff;
    /*margin:5px;*/
    margin:14px;
    }
    .pk p
    {
    	font-size:16px;
    }
    .bx .bx-body h4{
        color:#fff;
    }
    .pk p span
    {
    	font-size:14px;
    }
    /*.pk .btn-primary {
    background-color:#0591e7;
    }*/
    .pk .btn-primary {
     -moz-box-shadow:inset 0px 1px 0px 0px #54a3f7;
    -webkit-box-shadow:inset 0px 1px 0px 0px #54a3f7;
    box-shadow:inset 0px 1px 0px 0px #54a3f7;
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #007dc1), color-stop(1, #0061a7));
    background:-moz-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background:-webkit-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background:-o-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background:-ms-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background:linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#007dc1', endColorstr='#0061a7',GradientType=0);
    background-color:#007dc1;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
    border:1px solid #124d77;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:arial;
    font-size:13px;
    padding:6px 24px;
    text-decoration:none;
    text-shadow:0px 1px 0px #154682;

    }
    .pk .btn-primary:hover{

    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0061a7), color-stop(1, #007dc1));
    background:-moz-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background:-webkit-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background:-o-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background:-ms-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background:linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0061a7', endColorstr='#007dc1',GradientType=0);
    background-color:#0061a7;

    }
    .pk .btn {
    padding: 3px 15px;
    margin-top:15px;
    }
    @media only screen and (min-width : 992px) {
    	.price-list>.col-lg-2, .price-list>.col-md-2
    	{
    		width:14% !important;
    	}
    }
    #txtCustomAmount{
        color:#fff;
        font-size: 15px;
        padding-left: 5px;
        border:1px solid #0177BF;
        background-color: #28adfe;
    }

    .alert-danger{
        background-color: red;
        color:#fff;
        font-size: 25px;
    }

    .alert-danger span
    {
        padding-left: 20px;
        font-size: 17px;
    }
</style>
@stop
@section('script')
<script type="text/javascript" src="{{$base_url}}asset/js/icheck.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.rd_cat').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

});
</script>
@stop