@extends('front_master.master')
@section('content')
<div class="container-fluid reg-bg">
	<div id='brn_txt' class='col-lg-5 col-lg-offset-5 col-md-5 col-md-offset-5'>
	<h2><strong>YOUR FRIEND </strong> {{ strtoupper($u_name) }} INVITED YOU</h2>
	<h2>TO JOIN iconpreparation.com</h2>
	<h3> GET ONE WEEK FREE</h3>
	<h4>&amp; INVITE MORE FRIENDS TO <span>GET MORE FREE ACCESS</span></h4>
	</div>
</div>
<div class="container reg-content" style='min-height:400px;'>
	<div class="col-lg-9 col-lg-offset-2">
		<form action="{{ $base_url }}public/user_reg/ref_reg" method="POST" class="form-horizontal" role="form">
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
					<legend class='text-center'>REGISTER <span></span></legend>
				</div>
				<div class="clearfix"></div>
				@if($ci->session->flashdata('error'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 {{ $ci->session->flashdata('error') }}
					</div>
				@endif
				<input type="hidden" name="hdn_ref_uid" value="{{ $ref_user_id }}">
				<input type="hidden" name="hdn_ref_str" value="{{ $ref_str }}">
				<div class="form-group">
					<label for="txt_email" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Email</label>
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
						<input type="text" name="txt_email" id="txt_email" class="form-control" placeholder="Email" required value="{{ old_value('email') }}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="txt_mobile" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Mobile Number</label>
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
						<input type="text" name="txt_mobile" id="txt_mobile" class="form-control" placeholder="Mobile Number" required >
					</div>
				</div>

				<div class="form-group">
					<label for="txt_password" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Password</label>
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
						<input type="password" name="txt_password" id="txt_password" class="form-control" placeholder="Password" required>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_conf_password" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Confirm Password</label>
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
						<input type="password" name="txt_conf_password" id="txt_conf_password" class="form-control" placeholder="Confirm Password" required>
					</div>
				</div>
		
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-3">
						<button type="submit" class="btn btn-default">REGISTER</button>
					</div>
				</div>
		</form>
	</div>
</div>
@stop


@section('style')
<style>
	.reg-bg
	{
		min-height:410px;
		/*width:100%;*/
		background:url('{{ $base_url }}asset/frontend/new/img/reg-bg.jpg') no-repeat top center;
		background-size: cover;
	}
	.reg-bg h2,.reg-bg h3,.reg-bg h4{
		color:#fff;
	}
	.reg-bg h2{
		font-weight: 300;
	}
	.reg-bg h2 strong{
		font-weight: 500;
	}
	.reg-bg h3,.reg-bg h4 span{
		color:#F5DA45;
	}

	@media(max-width: 768px)
	{

	}

	#brn_txt{
		/*width:45%;*/
		padding-top: 84px;

	}
	legend{
		border-bottom: 1px solid #fff;
		/*padding-left: 5%;*/
		padding-top:10%;
		padding-bottom:20px;
		color:#4E8FB5;
		font-weight: 400;
	}
	legend span{
		margin:0 auto;
		display: block;
		width:80px;
		line-height: 15px;
		border-bottom: 3px solid #4E8FB5;
	}
</style>

@stop

@section('fbmeta')
<meta property="og:url" content="{{ $base_url }}'public/user_reg/register/{{ $ref_str }}" />
<meta property="og:title" content="Iconpreparation is an awesome platform for BCS, Bank Job, NTRCA and all types of job Preparation. " />
<meta property="og:type" content="article" />
<meta property="og:description" content="Register now to learn, prepare and improve yourself." />
<meta property="og:image" content="{{ $base_url }}asset/frontend/new/img/preview.jpg" />
@stop