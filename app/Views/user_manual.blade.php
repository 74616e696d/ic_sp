@extends('front_master.master')

@section('content')
<div class='container reg' style='min-height:350px;padding-top:25px;line-height:28px;'>
<h3>How To Register</h3>
<p>There is mainly two ways to register in Iconpreparation.</p>
<ol>
	<li>Registration By Facebook</li>
	<li>Manual Registration</li>
</ol>

<h4>Registration By Facebook</h4>
<p>
If you have a facebook account then you can register in Iconpreparation by just one click.Just Go to homepage and click on <span class='text-danger'>Login With Facebook</span>(Figure 1) button. Remember you need to set a password after registering or login with facebook for login manualy in Iconpreparation.

<figure>
<img src="{{ $base_url }}asset/frontend/img/reg_fb.jpg" alt="Facebook Registration">
<figcaption>Figure 1 : Facebook Registration</figcaption>
</figure>
</p>
<h4>Manual Registration</h4>
<p>To register manualy just click <span class='text-danger'>SIGNUP</span>(Figure 2) button in menu.
<figure>
	<img src="{{ $base_url }}asset/frontend/img/reg_man2.jpg" alt="Registration">
	<figcaption>Figure 2 : Manual Registration Link 1</figcaption>
</figure>
</p>
<p>
Or click <span class='text-danger'>Sign Up Now</span>(Figure 3) link under login area in home page.
<figure>
	<img src="{{ $base_url }}asset/frontend/img/reg_man1.jpg" alt="Registration">
	<figcaption>Figure 3 : Manual Registration Link 2</figcaption>
</figure>
</p>

<p>
	Fill all the necessary field(Figure 4) in this form and click sign up button. After successfull registration you will be redirected to dashboard.
	<figure>
		<img src="{{ $base_url }}asset/frontend/img/reg.jpg" alt="Registration Page">
		<figcaption>Figure 4 : Registration Page</figcaption>
	</figure>
</p>

<p><strong>Enjoy !</strong></p>
</div>
@stop

@section('style')

<style>
h3,h4{
	color: #0177BF;
}
.reg p{
	font-size: 16px;
	line-height: 30px;
}
.text-danger{
	font-weight: bold;
}
.figure{
	width: 100%;
}
.figcaption{
	text-align: center;
}
.reg img{
	max-width: 100%;
	 height: auto;
	 width: auto\9; /* ie8 */
}

</style>
@stop

@section('script')

@stop
