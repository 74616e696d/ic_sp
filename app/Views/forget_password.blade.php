@extends('front_layout.layout')

@section('content')
<div class="container forget">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>Reset your Iconpreparation password</h1>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p>No worries, it happens to all of us. In a few seconds you’ll be able to login to your account again.</p>
		<p>Follow these steps:</p>
		<ul class="list-unstyled">
			<li>Enter your email address and click Reset.</li>
			<li>We will send you an email. Click on the button to reset your password.</li>
			<li>Once you change your password, you can log in to your account.</li>
		</ul>
	</div>

	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 padding_top20">
		<form method="post" role='form' action="<?php echo base_url(); ?>login/forget_password_mail" >
			{{render_message()}}
			<div class="form-group">
			<input type="email" class='form-control' name="txt_email" id="txt_email" required='required' placeholder='Your Email'>
			</div>
			<!-- <div class="sep"></div> -->
			<div class="form-group">
			<button class="btn btn-primary btn-block" type='submit'>Submit</button>
			</div>
		</form>
	</div>
	
</div>

<br><br>
@stop

@section('style')
<style>
	.h1, .h2, .h3, .h4, .h5, .h6, body, h1, h2, h3, h4, h5, h6{
		font-family:"Roboto",sans-serif;
	}
	.forget{
		padding-top:15px;
	}
	.forget p{
		font-size: 16px;
	}
</style>
@stop
