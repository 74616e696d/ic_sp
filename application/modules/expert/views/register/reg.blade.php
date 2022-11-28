<form action="{{ $base_url }}expert/register/reg" method="POST" class="form-horizontal form-reg" role="form">
	@if($ci->session->flashdata('errors'))
	<?php $errors=$ci->session->flashdata('errors');?>
		{{ var_dump($errors) }}
		@foreach($errors as $error)
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{ $error }}
		</div>
		@endforeach
	@endif

		<div class="form-group">
			<label for="name" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">Name</label>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<input type="text" name="name" id="name" class="form-control" placeholder="Name" required value="{{ old_value('name') }}">
			</div>
		</div>

		<div class="form-group">
			<label for="email" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">Email</label>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<input type="email" name="email" id="email" class="form-control" placeholder="Email" required value="{{ old_value('email') }}">
			<span class='error errEmail'></span>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">Password</label>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
			</div>
		</div>	

		<div class="form-group">
			<label for="conf_password" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">Confirm Password</label>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<input type="password" name="conf_password" id="conf_password" class="form-control" placeholder="Cconfirm Password" required>
			</div>
		</div>	

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-3">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Register</button>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-3">
				Already registered ! <a href="{{ $base_url }}expert/login">Login Here</a>
			</div>
		</div>
</form>